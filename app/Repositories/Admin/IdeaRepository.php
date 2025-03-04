<?php

namespace App\Repositories\Admin;

use App\Models\Idea;
use App\Models\User;
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
        $idea = Idea::with(['categories:id,name,description', 'user', 'closure', 'documents', ])->adminSort($request->sortType, $request->sortBy)->adminSearch($request->search)->latest();

        if (request()->has('paginate')) {
            $idea = $idea->paginate(request()->get('paginate'));
        } else {
            $idea = $idea->paginate(10);
        }

        return $idea;
    }

    public function create(array $data): Idea
    {
        $idea = Idea::create([
            'title'  => $data['title'],
            'content' => $data['content'],
            'closure_id' => $data['closure_id'],
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
        return Idea::where('id', $id)->with(['categories:id,name,description', 'user', 'closure', 'documents'])->first();
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

    public function increaseViews(Idea $idea)
    {
        $idea->increment('views');
    }

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
