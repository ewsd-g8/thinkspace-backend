<?php

namespace App\Repositories\Admin;


use App\Enums\Status;
use App\Models\Department;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;


class DepartmentRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return Department::class;
    }

    public function getDepartments($request)
    {
        $departments = Department::select('id', 'name', 'description', 'is_active', 'color', 'created_at', 'updated_at')
        ->adminSort($request->sortType, $request->sortBy)
        ->adminSearch($request->search)
        ->latest();

        if (request()->has('paginate')) {
            $departments = $departments->paginate(request()->get('paginate'));
        } else {
            $departments = $departments->paginate(10);
        }
        return $departments;
    }

    public function create(array $data): Department
    {
        $department = Department::create([
            'name'  => $data['name'],
            'color' => $data['color'],
            'description' => $data['description'],
            'is_active' => Status::Active,
        ]);

        return $department;
    }

    public function update(Department $department, array $data): Department
    {
        $department->name = isset($data['name']) ? $data['name'] : $department->name;
        $department->color = isset($data['color']) ? $data['color'] : $department->color;
        $department->description = isset($data['description']) ? $data['description'] : $department->description;
        $department->save();

        return $department;
    }

    public function changeStatus(Department $department)
    {
        $newStatus = $department->is_active == 1 ? 0 : 1;

        $department->update([
            'is_active' => $newStatus,
            'updated_at' => now(),
        ]);

        return $department->refresh();
    }

    public function getDepartmentById($id)
    {
        return Department::find($id);
    }

}