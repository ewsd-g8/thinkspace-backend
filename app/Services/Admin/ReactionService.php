<?php

namespace App\Services\Admin;

use App\Repositories\Admin\ReactionRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class ReactionService 
{
    protected $reactionRepository;
    
    public function __construct (ReactionRepository $reactionRepository) {
        $this->reactionRepository = $reactionRepository;
    }

    public function setReaction ($userId, $ideaId, $type)
    {
        DB::beginTransaction();
        try {
            $result = $this->reactionRepository->setReaction($userId, $ideaId, $type);
        } 
        catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to set reaction');
        }
        DB::commit();
        return $result;
    }

    public function getIdeaLikeCount ($ideaId)
    {
        return $this->reactionRepository->getIdeaLikeCount($ideaId);
    }

    public function getIdeaUnlikeCount ($ideaId)
    {
        return $this->reactionRepository->getIdeaUnlikeCount($ideaId);
    }

    public function getUserReactionForIdea ($userId, $ideaId)
    {
        return $this->reactionRepository->getUserReactionForIdea($userId, $ideaId);
    }
}