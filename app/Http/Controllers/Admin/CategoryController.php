<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\CreateCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controllers\HasMiddleware;

class CategoryController extends Controller implements HasMiddleware
{
    /**
     * @var CategoryService
     */
    protected $catergoryService;
    public static function middleware(): array
    {
        return [
            new Middleware('permission:category-list', only: ['index', 'show']),
            new Middleware('permission:category-create', only: ['store']),
            new Middleware('permission:category-edit', only: ['update', 'changeStatus'])
        ];

    }

    public function __construct(CategoryService $categoryService)
    {
        $this->catergoryService = $categoryService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = $this->catergoryService->getCategories($request);

        return response()->success('Success!', Response::HTTP_OK, $categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        $this->catergoryService->create($request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->catergoryService->getCategory($id);

        return response()->success('Success!', Response::HTTP_OK, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->catergoryService->update($category, $request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changeStatus(Category $category)
    {
        $changedStatus = $this->catergoryService->changeStatus($category);

        return response()->success('Success!', Response::HTTP_OK, $changedStatus);
    }

    public function getAllCategories()
    {
        $data = $this->catergoryService->getAllCategories();

        return response()->success('Success', Response::HTTP_OK, $data); 
    }
}
