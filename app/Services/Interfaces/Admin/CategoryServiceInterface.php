<?php

namespace App\Services\Interfaces\Admin;

use App\Models\Category;
use Illuminate\Http\Request;

interface CategoryServiceInterface
{
    public function getCategories(Request $request);
    public function create(array $data);
    public function update(Category $category, array $data);
    public function getCategory($id);
    public function changeStatus(Category $category);
    public function getAllCategories();
}
