<?php

namespace App\Http\Controllers\Admin;

use App\Models\Idea;
use Illuminate\Http\Request;
use App\Services\Admin\ideaService;
use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Admin\Idea\CreateIdeaRequest;
use App\Http\Requests\Admin\Idea\UpdateIdeaRequest;

class IdeaController extends Controller implements HasMiddleware
{
    
    protected $ideaService;
    public static function middleware(): array
    {
        return [
            new Middleware('permission:idea-list', only: ['index', 'show']),
            new Middleware('permission:idea-create', only: ['store']),
            new Middleware('permission:idea-edit', only: ['update'])
        ];

    }

    public function __construct(IdeaService $ideaService)
    {
        $this->ideaService = $ideaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ideas = $this->ideaService->getIdeas($request);

        return response()->success('Success!', Response::HTTP_OK, $ideas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIdeaRequest $request)
    {
        $this->ideaService->create($request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->ideaService->getIdea($id);

        return response()->success('Success!', Response::HTTP_OK, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        $this->ideaService->update($idea, $request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
