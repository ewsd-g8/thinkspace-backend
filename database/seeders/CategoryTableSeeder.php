<?php

namespace Database\Seeders;

use App\Models\Category; // Adjust namespace if your Category model is elsewhere
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Sustainability',
                'description' => 'Initiatives focused on reducing environmental impact and promoting sustainable practices across campus, including energy efficiency, waste reduction, and renewable energy projects.',
                'is_active' => true,
            ],
            [
                'name' => 'Education Enhancement',
                'description' => 'Programs and tools designed to improve teaching and learning experiences, such as smart classrooms, virtual resources, and faculty development opportunities.',
                'is_active' => true,
            ],
            [
                'name' => 'Staff Development',
                'description' => 'Efforts to support staff growth and well-being, including skill-building grants, flexible scheduling, and wellness platforms to enhance professional and personal lives.',
                'is_active' => true,
            ],
            [
                'name' => 'Campus Community',
                'description' => 'Projects aimed at fostering a stronger sense of community, through events like arts festivals, dialogue series, and platforms connecting alumni with current campus needs.',
                'is_active' => true,
            ],
            [
                'name' => 'Health and Wellness',
                'description' => 'Initiatives promoting physical and mental health for students and staff, including health fairs, training suites, and campaigns for healthy living habits.',
                'is_active' => true,
            ],
            [
                'name' => 'Technology Innovation',
                'description' => 'Advancements in campus technology, such as app revamps, cybersecurity training, and prototyping centers to support cutting-edge education and operations.',
                'is_active' => true,
            ],
            [
                'name' => 'Equity and Inclusion',
                'description' => 'Efforts to ensure a fair and inclusive campus environment, covering ethics training, legal support, and dialogues on diversity and belonging.',
                'is_active' => true,
            ],
            [
                'name' => 'Creative Expression',
                'description' => 'Opportunities for artistic exploration and display, including rotating art exhibits, interdisciplinary labs, and festivals celebrating staff and student creativity.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'description' => $category['description'],
                'is_active' => $category['is_active'],
            ]);
        }
    }
}