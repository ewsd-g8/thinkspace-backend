<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\View;
use App\Services\Admin\ViewService;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Admin\View\IncreaseViewRequest;

class ViewController extends Controller
{
    protected $viewService;

    public function middleware(): array{
        return [
            new Middleware('permission:view-create', only: ['increaseView']),
            new Middleware('permission:view-list', only: ['getUsersViewByIdea']),
        ];
    }

    public function __construct(ViewService $viewService)
    {
        $this->viewService = $viewService;
    }

    public function store(IncreaseViewRequest $request)
    {
        $this->viewService->increaseView($request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    public function getUsersViewByIdea($ideaId)
    {
        $views = $this->viewService->getUsersViewByIdea($ideaId);

        return response()->success('Success!', Response::HTTP_OK, $views);
    }
}
