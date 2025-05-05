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
                'description' => 'Faculty of Engineering - Mechanical, Electrical, and Civil programs'
            ],
            [
                'name' => 'Business',
                'color' => '#5bb618',
                'description' => 'School of Business - Management, Economics, and Accounting'
            ],
            [
                'name' => 'Arts and Science',
                'color' => '#1859b6',
                'description' => 'Faculty of Arts and Science - Humanities and Natural Sciences'
            ],
            [
                'name' => 'Human Resources',
                'color' => '#ff6b6b',
                'description' => 'University HR Department - Staff and Faculty administration'
            ],
            [
                'name' => 'Medicine',
                'color' => '#4ecdc4',
                'description' => 'School of Medicine - Medical education and research'
            ],
            [
                'name' => 'Law',
                'color' => '#45b7d1',
                'description' => 'Faculty of Law - Legal studies and practice'
            ],
            [
                'name' => 'Computer Science',
                'color' => '#96ceb4',
                'description' => 'Department of Computer Science - Computing and technology programs'
            ],
            [
                'name' => 'Education',
                'color' => '#ffeead',
                'description' => 'School of Education - Teacher training and pedagogy'
            ],
            [
                'name' => 'Social Sciences',
                'color' => '#d4a4eb',
                'description' => 'Faculty of Social Sciences - Sociology, Psychology, and Anthropology'
            ],
            [
                'name' => 'Fine Arts',
                'color' => '#ffcc5c',
                'description' => 'Department of Fine Arts - Visual arts, music, and theater'
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
