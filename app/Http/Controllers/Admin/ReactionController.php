<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Reaction\SetReactionRequest;
use App\Services\Admin\ReactionService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;

class ReactionController extends Controller implements HasMiddleware
{
    protected $reactionService;
    public static function middleware(): array
    {
        return [
            new Middleware('permission:reaction-list', only:['getIdeaReactionCount','getUserReactionForIdea']),
            new Middleware('permission:reaction-create', only: ['store']),
        ];
    }

    public function __construct(ReactionService $reactionService)
    {
        $this->reactionService = $reactionService;
    }

    public function store (SetReactionRequest $request)
    {
        $userId = auth()->user()->id;
        $ideaId = $request->input('idea_id');
        $type = $request->input('type');

        $result = $this->reactionService->setReaction($userId, $ideaId, $type);

        return $result === null ? response()->success('Reaction removed', Response::HTTP_OK)
                                : response()->success('Reaction set', Response::HTTP_OK, $result);
    }
}
