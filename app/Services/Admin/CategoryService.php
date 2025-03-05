<?php

namespace App\Services\Admin;

use App\Models\Category;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Admin\CategoryRepository;
use App\Services\Interfaces\Admin\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategories($request)
    {
        $result = $this->categoryRepository->getCategories($request);

        return $result;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->categoryRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create category');
        }
        DB::commit();

        return $result;
    }

    public function getCategory($id)
    {
        return $this->categoryRepository->getCategory($id);
    }

    public function update(Category $category, array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->categoryRepository->update($category, $data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update category');
        }
        DB::commit();

        return $result;
    }

    public function changeStatus(Category $category)
    {
        return $this->categoryRepository->changeStatus($category);
    }

    public function getAllCategories()
    {
        return $this->categoryRepository->getAllCategories();
    }
}
