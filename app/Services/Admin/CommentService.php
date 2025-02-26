<?php

namespace App\Services\Admin;

use App\Models\Comment;
use Exception;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Admin\CommentRepository;
use App\Services\Interfaces\Admin\CommentServiceInterface;

class CommentService implements CommentServiceInterface
{
    
    protected $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getComments(Request $request)
    {
        return $this->commentRepository->getComments($request);
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->commentRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create comment');
        }
        DB::commit();

        return $result;
    }

    public function update(Comment $comment, array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->commentRepository->update($comment, $data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update comment');
        }
        DB::commit();

        return $result;
    }

    public function getCommentById($id)
    {
        return $this->commentRepository->getCommentById($id);
    }

}
