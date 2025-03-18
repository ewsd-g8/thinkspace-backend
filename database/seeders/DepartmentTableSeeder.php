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
                'name' => 'Engineering',
                'color' => '#b63418',
                'description' => 'Engineering Department'
            ],
            [
                'name' => 'Business',
                'color' => '#5bb618',
                'description' => 'Business Department'
            ],
            [
                'name' => 'Arts and Science',
                'color' => '#1859b6',
                'description' => 'Arts and Science Department'
            ]
        ];

        foreach ($departments as $department) {
            $department = Department::create([
                'name' => $department['name'],
                'color' => $department['color'],
                'description' => $department['description']
            ]);
        }
    }
}
