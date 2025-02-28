<?php

namespace App\Repositories\Admin;

use App\Models\Reaction;

class ReactionRepository
{
    /**
     * @return string
     */

    public function model()
    {
        return Reaction::class;
    }

    public function setReaction ($userId, $ideaId, $type)
    {
        $reaction = Reaction::where('user_id', $userId)->where('idea_id', $ideaId)->first();

        if (!$reaction) {
            $reaction = Reaction::create([
                'type' => $type,
                'user_id' => $userId,
                'idea_id' => $ideaId,
            ]);
            return $reaction;
        }
        else {
            if ($reaction->type == $type) {
                $reaction->delete();
                return null;
            }
            else {
                $reaction->type = $type;
                $reaction->save();
                return $reaction;
            }
        }
    }

    public function getIdeaLikeCount ($ideaId) 
    {
        $likeCount = Reaction::where('idea_id', $ideaId)->where('type', true)->count();
        return ['likes' => $likeCount];
    }

    public function getIdeaUnlikeCount ($ideaId) 
    {
        $unlikeCount = Reaction::where('idea_id', $ideaId)->where('type', false)->count();
        return ['unlikes' => $unlikeCount];
    }

    public function getUserReactionForIdea ($userId, $ideaId)
    {
        $reaction = Reaction::where('user_id', $userId)->where('idea_id', $ideaId)->first();
        return [
            'idea_id' => $ideaId,
            'type' => $reaction ? $reaction->type : null
        ];
    }
}