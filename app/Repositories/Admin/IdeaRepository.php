<?php

namespace App\Repositories\Admin;

use App\Models\Idea;

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
        $idea = Idea::select('id', 'title', 'content', 'views')->with(['categories:id,name,description'])->adminSort($request->sortType, $request->sortBy)->adminSearch($request->search)->latest();

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

        return $idea;
    }

    public function getIdea($id)
    {
        return Idea::where('id', $id)->first();
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
