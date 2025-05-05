<?php

namespace App\Services\Interfaces\Admin;

use App\Models\Comment;
use Illuminate\Http\Request;

interface CommentServiceInterface
{
    public function getComments(Request $request);
    public function create(array $data);
    public function update(Comment $comment, array $data);
    public function getCommentById($id);
}
