<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Services\Admin\CommentService;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Admin\Comment\CreateCommentRequest;
use App\Http\Requests\Admin\Comment\UpdateCommentRequest;
class CommentController extends Controller implements HasMiddleware
{
    protected $commentService;
    public static function middleware(): array
    {
        return [
            new Middleware('permission:comment-list', only:['index','show']),
            new Middleware('permission:comment-create', only: ['store']),
            new Middleware('permission:comment-edit', only: ['update']),
            new Middleware('permission:comment-delete', only: ['destroy'])
        ];
    }


    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index(Request $request)
    {
        $comments = $this->commentService->getComments($request);

        return response()->success('Success!', Response::HTTP_OK, $comments);
    }


    public function store(CreateCommentRequest $request)
    {
        $this->commentService->create($request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    
    public function show(string $id)
    {
        $data = $this->commentService->getCommentById($id);

        return response()->success('Success!', Response::HTTP_OK, $data);
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $this->commentService->update($comment, $request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        if (!empty($comment)) {
            $comment->delete();
            return response()->json([
                'message' => 'Comment Deleted!'
            ], 200);
        } else {
            return response()->json([
                'message' => 'Comment not found'
            ], 404);
        }
    }

}
