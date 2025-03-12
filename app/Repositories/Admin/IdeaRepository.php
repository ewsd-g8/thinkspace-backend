<?php

namespace App\Repositories\Admin;

use App\Models\Idea;
use App\Models\Document;
use App\Helpers\MediaHelper;
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
<<<<<<< Updated upstream
        $idea = Idea::with(['categories:id,name,description', 'user', 'closure', 'documents', 'comments'])->withCount([
            'comments', 'views',
            'reactions as likes' => function ($query) {
                $query->where('type', true);
            },
            'reactions as unlikes' => function ($query) {
                $query->where('type', false);
            }])
            ->adminSort($request->sortType, $request->sortBy)->adminSearch($request->search)->latest();
=======
        $query = Idea::with([
            'categories:id,name,description',
            'user.department' => function ($query) { // Explicitly load department
                $query->select('id', 'name');
            },
            'closure',
            'documents',
            'comments'
        ])
            ->withCount([
                'comments',
                'views',
                'reactions as likes' => function ($query) {
                    $query->where('type', true);
                },
                'reactions as unlikes' => function ($query) {
                    $query->where('type', false);
                }
            ]);
>>>>>>> Stashed changes

        // Search filter
        if ($request->search) {
            $query->adminSearch($request->search);
        }

<<<<<<< Updated upstream
        return $idea->through(function ($item) {
            $item->user_reaction = $item->getUserReactionAttribute();
=======
        // Category filter (single value)
        if ($request->category) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('name', $request->category);
            });
        }

        // Department filter (single value)
        if ($request->department) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->whereHas('department', function ($d) use ($request) {
                    $d->where('name', $request->department);
                });
            });
        }

        // Closure filter (single value)
        if ($request->closure) {
            $query->whereHas('closure', function ($q) use ($request) {
                $q->where('name', $request->closure);
            });
        }

        // Sorting
        if ($request->sort) {
            switch ($request->sort) {
                case 'newest':
                    $query->latest('created_at');
                    break;
                case 'oldest':
                    $query->oldest('created_at');
                    break;
                case 'mostLikes':
                    $query->orderBy('likes', 'desc');
                    break;
                case 'mostDislikes':
                    $query->orderBy('unlikes', 'desc');
                    break;
                    case 'mostViews': 
                        $query->orderBy('views_count', 'desc');
                        break;
                default:
                    $query->latest('created_at');
            }
        } else {
            $query->adminSort($request->sortType, $request->sortBy)->latest();
        }

        // Content length filter (optional)
        if ($request->contentLength) {
            $query->where(function ($q) use ($request) {
                if ($request->contentLength === 'short') {
                    $q->whereRaw('LENGTH(content) < 100');
                } elseif ($request->contentLength === 'medium') {
                    $q->whereRaw('LENGTH(content) >= 100 AND LENGTH(content) <= 400');
                } elseif ($request->contentLength === 'long') {
                    $q->whereRaw('LENGTH(content) > 400');
                }
            });
        }

        // Pagination
        $paginate = $request->input('paginate', 5);
        $ideas = $query->paginate($paginate);

        return $ideas->through(function ($item) {
            $item->user_reaction = $item->getUserReactionType();
>>>>>>> Stashed changes
            return $item;
        });
    }
    public function create(array $data): Idea
    {
        $idea = Idea::create([
            'title'  => $data['title'],
            'content' => $data['content'],
            'closure_id' => $data['closure_id'],
            "is_anonymous" => $data['is_anonymous'],
            'user_id' => $data['user_id'],
        ]);

        if (!empty($data['categories'])) {
            $idea->categories()->attach($data['categories']); // Attach categories
        }

        if (isset($data['documents'])) {
            if (count($data['documents'])) {
                for ($document=0; $document < count($data['documents']) ; $document++) {
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

    public function getIdea($id)
    {
        $idea = Idea::where('id', $id)->with(['categories:id,name,description', 'user', 'closure', 'documents', 'comments'])
            ->withCount(['comments', 'views', 
            'reactions as likes' => function ($query) {
                $query->where('type', true);
            },
            'reactions as unlikes' => function ($query) {
                $query->where('type', false);
            }])
            ->first();

        if($idea) {
            $idea->user_reaction = $idea->getUserReactionType();
        }
        return $idea;
    }

    public function update(Idea $idea, array $data): Idea
    {
        $idea->title = isset($data['title']) ? $data['title'] : $idea->title;
        $idea->content = isset($data['content']) ? $data['content'] : $idea->content;
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

                for ($document=0; $document < count($data['documents']) ; $document++) {
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
<<<<<<< Updated upstream

    public function increaseViews(Idea $idea)
    {
        $idea->increment('views');
    }

=======
    
>>>>>>> Stashed changes
    //  public function changeStatus(Closure $closure)
    //  {
    //      if ($closure->is_active == 0) {
    //          $closure->update([
    //              'is_active' => 1,
    //          ]);

    //          return $closure->refresh();
    //      } else {
    //          $closure->update([
    //              'is_active' => 0,
    //          ]);

    //          return $closure->refresh();
    //      }
    //  }
}
