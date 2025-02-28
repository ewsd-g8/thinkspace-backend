<?php

namespace App\Services\Interfaces\Admin;

use App\Models\Reaction;
use Illuminate\Http\Request;

interface ReactionServiceInterface
{
    public function setReaction ($userId, $ideaId, $type);
    public function getIdeaLikeCount ($ideaId);
    public function getIdeaUnlikeCount ($ideaId);
    public function getUserReactionForIdea ($userId, $ideaId);
}
