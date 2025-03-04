<?php

namespace App\Repositories\Admin;

use App\Enums\Status;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class CategoryRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    public function getCategories($request)
    {
        $categories = Category::select('id', 'name', 'description', 'is_active', 'created_at', 'updated_at')->adminSort($request->sortType, $request->sortBy)->adminSearch($request->search)->latest();

        if (request()->has('paginate')) {
            $categories = $categories->paginate(request()->get('paginate'));
        } else {
            $categories = $categories->paginate(10);
        }

        return $categories;
    }

    public function create(array $data): Category
    {
        $category = Category::create([
            'name'  => $data['name'],
            'description' => $data['description'],
            'is_active' => Status::Active,
        ]);

        return $category;
    }

    public function getCategory($id)
    {
        return Category::where('id', $id)->first();
    }

    public function update(Category $category, array $data): Category
    {
        $category->name = isset($data['name']) ? $data['name'] : $category->name;
        $category->description = isset($data['description']) ? $data['description'] : $category->description;
        
        if ($category->isDirty()) {
            $category->save();
        }

        return $category;
    }

    public function changeStatus(Category $category)
    {
        if ($category->is_active == 0) {
            $category->update([
                'is_active' => 1,
            ]);

            return $category->refresh();
        } else {
            $category->update([
                'is_active' => 0,
            ]);

            return $category->refresh();
        }
    }

    public function getAllCategories($request)
    {
        $categories = Category::select('id', 'name', 'description', 'is_active');

        return $categories;
    }
}
