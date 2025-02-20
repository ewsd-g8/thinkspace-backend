<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'IT',
                'description' => 'IT Department'
            ]
            ];

        foreach ($departments as $department) {
            $department = Department::create([
                'name' => $department['name'],
                'description' => $department['description']
            ]);
        }
    }
}
