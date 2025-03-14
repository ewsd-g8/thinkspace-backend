<?php

namespace App\Services\Interfaces\Admin;

use App\Models\Department;
use Illuminate\Http\Request;

interface DepartmentServiceInterface
{
    public function getDepartments(Request $request);
    public function getDepartmentById($id);
    public function create(array $data);
    public function update(Department $department, array $data);
    public function changeStatus(Department $department);
}