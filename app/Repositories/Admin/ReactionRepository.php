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
}