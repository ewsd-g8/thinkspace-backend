<?php

namespace App\Repositories\Admin;

use App\Enums\Status;
use App\Mail\IdeaPostedEmail;
use App\Models\Idea;
use App\Models\Document;
use App\Helpers\MediaHelper;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class IdeaRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Idea::class;
    }

    public function getIdeas($request)
    {
        $idea = Idea::with(['categories:id,name,description', 'user', 'closure', 'documents', 'comments','reports'])
            ->withCount([
                'comments',
                'views',
                'reports',
                'reactions as likes' => function ($query) {
                    $query->where('type', true);
                },
                'reactions as unlikes' => function ($query) {
                    $query->where('type', false);
                }
            ])
            ->filterHiddenUser()
            ->when($request->user_id, function ($query) use ($request) {
                $query->where('user_id', $request->user_id);
            }) 
            ->when(!$request->active_only, function ($query) {
                
            }, function ($query) {
                $query->where('is_active', 1); 
            })
            ->when($request->search, function ($query) use ($request) {
                $query->adminSearch($request->search);
            })
            ->when($request->category, function ($query) use ($request) {
                $query->filterByCategory($request->category);
            })
            ->when($request->department, function ($query) use ($request) {
                $query->filterByDepartment($request->department);
            })
            ->when($request->closure, function ($query) use ($request) {
                $query->filterByClosure($request->closure);
            })
            ->when($request->contentLength, function ($query) use ($request) {
                $query->filterByContentLength($request->contentLength);
            })
            ->when($request->sort, function ($query) use ($request) {
                $query->customSort($request->sort);
            }, function ($query) use ($request) {
                $query->adminSort($request->sortType, $request->sortBy);
            });

        if (request()->has('paginate')) {
            $idea = $idea->paginate(request()->get('paginate'));
        } else {
            $idea = $idea->paginate(5);
        }

        return $idea->through(function ($item) {
            $item->user_reaction = $item->getUserReactionType();
            return $item;
        });
    }

    public function create(array $data): Idea
    {
        $idea = Idea::create([
            'title'  => $data['title'],
            'content' => $data['content'],
            'is_active' => Status::Active,
            'is_anonymous' => $data['is_anonymous'],
            'closure_id' => $data['closure_id'],
            'user_id' => $data['user_id'],
        ]);

        if (!empty($data['categories'])) {
            $idea->categories()->attach($data['categories']);
        }

        if (isset($data['documents'])) {
            if (count($data['documents'])) {
                for ($document = 0; $document < count($data['documents']); $document++) {
                    $mediaHelper = new MediaHelper($data['documents'][$document], 'documents');
                    $media = $mediaHelper->save();
                    if ($media['status'] == false) {
                        return response()->error($media['message'], Response::HTTP_BAD_REQUEST, ['document' => ['Invalid format!']]);
                    }

                    $idea->profile = $media['storage_path'];

                    Document::create([
                        'file_path' => $media['storage_path'],
                        'idea_id' => $idea->id
                    ]);
                }
            }
        }

        $user = $idea->user;
        $departmentId = $idea->user->department_id;
        $qaCoordinators = User::where('department_id', $departmentId)
                        ->whereHas('roles', function ($query) {
                            $query->where('name', 'QAcoordinator');
                        })->get();

        
        //send email to all qaCoordinators in the department
        if ($qaCoordinators->isNotEmpty()) {
            foreach ($qaCoordinators as $qaCoordinator) {
                Mail::to($qaCoordinator->email)->send(new IdeaPostedEmail($idea, $user));
            }
        }

        return $idea;
    }

    public function getIdea($id, $sortLatest = true)
    {
        $idea = Idea::where('id', $id)->with(['categories:id,name,description', 'user', 'closure', 'documents',
                'comments' => function ($query) use ($sortLatest) {
                    $query->orderBy('created_at', $sortLatest === true ? 'desc' : 'asc')->with('user');
                }
                ,'reports' => function ($query) {
                    $query->with([
                        'user:id,full_name,email',
                        'reportType:id,name'
                    ]);
                }
                
                ])
            ->withCount([
                'comments',
                'views',
                'reports',
                'reactions as likes' => function ($query) {
                    $query->where('type', true);
                },
                'reactions as unlikes' => function ($query) {
                    $query->where('type', false);
                }
            ])
            ->first();

        if ($idea) {
            $idea->user_reaction = $idea->getUserReactionType();
        }
        return $idea;
    }

    public function update(Idea $idea, array $data): Idea
    {
        $idea->title = isset($data['title']) ? $data['title'] : $idea->title;
        $idea->content = isset($data['content']) ? $data['content'] : $idea->content;
        $idea->is_anonymous = isset($data['is_anonymous']) ? $data['is_anoonymous'] : $idea->is_anonymous;
        $idea->closure_id = isset($data['closure_id']) ? $data['closure_id'] : $idea->closure_id;
        $idea->user_id = isset($data['user_id']) ? $data['user_id'] : $idea->user_id;

        if ($idea->isDirty()) {
            $idea->save();
        }

        if (!empty($data['categories'])) {
            $idea->categories()->sync($data['categories']);
        }

        if (isset($data['documents'])) {
            if (count($data['documents'])) {

                $documents = $idea->documents;
                if ($documents->count()) {
                    foreach ($documents as $document) {
                        $path = parse_url($document->file_path, PHP_URL_PATH);
                        $pathParts = explode('/', $path);
                        $filepath = implode('/', array_slice($pathParts, 2));

                        if ($filepath && Storage::exists($filepath)) {
                            Storage::delete($filepath);
                        }
                        $document->delete();
                    }
                }

                for ($document = 0; $document < count($data['documents']); $document++) {
                    $mediaHelper = new MediaHelper($data['documents'][$document], 'documents');
                    $media = $mediaHelper->save();
                    if ($media['status'] == false) {
                        return response()->error($media['message'], Response::HTTP_BAD_REQUEST, ['document' => ['Invalid format!']]);
                    }

                    $idea->profile = $media['storage_path'];

                    Document::create([
                        'file_path' => $media['storage_path'],
                        'idea_id' => $idea->id
                    ]);
                }
            }
        }

        return $idea;
    }
    
    public function changeStatus(Idea $idea)
    {
        $newStatus = $idea->is_active == 1 ? 0 : 1;

        $idea->update([
            'is_active' => $newStatus,
            'updated_at' => now(),
        ]);

        return $idea->refresh();
    }

    public function getIdeasByClosure($closure_id)
    {
        return  Idea::where('closure_id', $closure_id)->get();
    }
}
