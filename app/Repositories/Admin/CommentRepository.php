<?php

namespace App\Repositories\Admin;


use App\Models\Comment;
use App\Mail\CommentMail;
use Illuminate\Support\Facades\Mail;


class CommentRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Comment::class;
    }

    public function getComments($request)
    {
        $comment = Comment::with(['user','idea'])->adminSort($request->sortType, $request->sortBy)->adminSearch($request->search)->latest();

        if (request()->has('paginate')) {
            $comment = $comment->paginate(request()->get('paginate'));
        } else {
            $comment = $comment->paginate(10);
        }
        return $comment;
    }

    public function create(array $data): Comment
    {
        $user = auth()->user();
        $comment = Comment::create([
            'content' => $data['content'],
            'is_anonymous' => $data['is_anonymous'],
            'user_id' => $user->id,
            'idea_id' => $data['idea_id'],
        ]);

        // Send email notification to the idea owner
        $idea = $comment->idea;
        $ideaowner = $idea->user;
        $commenter = $comment->user;
        if ($ideaowner->id != $commenter->id) {
           Mail::to($ideaowner->email)->send(new CommentMail($comment,  $commenter, $idea));
        }


        return $comment;
    }

    public function update(Comment $comment, array $data): Comment
    {
        $comment->content = isset($data['content']) ? $data['content'] : $comment->content;
        
        if ($comment->isDirty()) {
            $comment->save();
        }

        return $comment;
    }


    public function getCommentById($id)
    {
        return Comment::find($id);
    }

}