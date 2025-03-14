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
                'description' => 'Engineering Department'
            ],
            [
                'name' => 'Business',
                'description' => 'Business Department'
            ],
            [
                'name' => 'Arts and Science',
                'description' => 'Arts and Science Department'
            ],
            [
                'name' => 'Education',
                'description' => 'Education Department'
            ],
            [
                'name' => 'Health Science',
                'description' => 'Health Science Department'
            ],
        ];

        foreach ($departments as $department) {
            $department = Department::create([
                'name' => $department['name'],
                'description' => $department['description']
            ]);
        }
    }
}
