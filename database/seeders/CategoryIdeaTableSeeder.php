<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Idea;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryIdeaTableSeeder extends Seeder
{
    public function run()
    {
        $ideaCategories = [
            ['idea_title' => 'Campus-Wide Energy Retrofit Program', 'category_name' => 'Sustainability'],
            ['idea_title' => 'Campus-Wide Energy Retrofit Program', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Campus-Wide Energy Retrofit Program', 'category_name' => 'Technology Innovation'],
            ['idea_title' => 'Solar-Powered Engineering Complex', 'category_name' => 'Sustainability'],
            ['idea_title' => 'Solar-Powered Engineering Complex', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Solar-Powered Engineering Complex', 'category_name' => 'Technology Innovation'],
            ['idea_title' => 'Solar-Powered Engineering Complex', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Next-Generation Smart Classrooms', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Next-Generation Smart Classrooms', 'category_name' => 'Technology Innovation'],
            ['idea_title' => 'Wind Energy Research and Training Hub', 'category_name' => 'Sustainability'],
            ['idea_title' => 'Wind Energy Research and Training Hub', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Wind Energy Research and Training Hub', 'category_name' => 'Technology Innovation'],
            ['idea_title' => 'Advanced Prototyping Center Expansion', 'category_name' => 'Technology Innovation'],
            ['idea_title' => 'Advanced Prototyping Center Expansion', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Advanced Prototyping Center Expansion', 'category_name' => 'Creative Expression'],
            ['idea_title' => 'Advanced Prototyping Center Expansion', 'category_name' => 'Staff Development'],
            ['idea_title' => 'Advanced Prototyping Center Expansion', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Entrepreneurship Hub for Faculty and Students', 'category_name' => 'Staff Development'],
            ['idea_title' => 'Entrepreneurship Hub for Faculty and Students', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Entrepreneurship Hub for Faculty and Students', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Comprehensive Financial Education Series', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Comprehensive Financial Education Series', 'category_name' => 'Health and Wellness'],
            ['idea_title' => 'Green Purchasing Overhaul', 'category_name' => 'Sustainability'],
            ['idea_title' => 'Green Purchasing Overhaul', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Green Purchasing Overhaul', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Green Purchasing Overhaul', 'category_name' => 'Equity and Inclusion'],
            ['idea_title' => 'Alumni Crowdfunding Platform', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Alumni Crowdfunding Platform', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Alumni Crowdfunding Platform', 'category_name' => 'Technology Innovation'],
            ['idea_title' => 'University Efficiency Task Force', 'category_name' => 'Campus Community'],
            ['idea_title' => 'University Efficiency Task Force', 'category_name' => 'Sustainability'],
            ['idea_title' => 'Interdisciplinary Creativity Lab', 'category_name' => 'Creative Expression'],
            ['idea_title' => 'Interdisciplinary Creativity Lab', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Interdisciplinary Creativity Lab', 'category_name' => 'Technology Innovation'],
            ['idea_title' => 'Interdisciplinary Creativity Lab', 'category_name' => 'Campus Community'],
            ['idea_title' => 'University Open Research Portal', 'category_name' => 'Creative Expression'],
            ['idea_title' => 'University Open Research Portal', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Native Habitat Restoration Project', 'category_name' => 'Sustainability'],
            ['idea_title' => 'Native Habitat Restoration Project', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Native Habitat Restoration Project', 'category_name' => 'Creative Expression'],
            ['idea_title' => 'Community Science Speaker Series', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Staff Skill-Building Grant Program', 'category_name' => 'Staff Development'],
            ['idea_title' => 'Staff Skill-Building Grant Program', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Flexible Scheduling Pilot', 'category_name' => 'Staff Development'],
            ['idea_title' => 'Staff Wellness Mobile Platform', 'category_name' => 'Health and Wellness'],
            ['idea_title' => 'Staff Wellness Mobile Platform', 'category_name' => 'Staff Development'],
            ['idea_title' => 'Staff Wellness Mobile Platform', 'category_name' => 'Technology Innovation'],
            ['idea_title' => 'Annual Campus Health Fair', 'category_name' => 'Health and Wellness'],
            ['idea_title' => 'Annual Campus Health Fair', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Cutting-Edge Medical Training Suite', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Cutting-Edge Medical Training Suite', 'category_name' => 'Technology Innovation'],
            ['idea_title' => 'Cutting-Edge Medical Training Suite', 'category_name' => 'Health and Wellness'],
            ['idea_title' => 'Healthy Living Campus Initiative', 'category_name' => 'Health and Wellness'],
            ['idea_title' => 'Healthy Living Campus Initiative', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Campus Legal Support Line', 'category_name' => 'Equity and Inclusion'],
            ['idea_title' => 'Campus Legal Support Line', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Mandatory Ethics Bootcamp', 'category_name' => 'Equity and Inclusion'],
            ['idea_title' => 'University App Revamp', 'category_name' => 'Technology Innovation'],
            ['idea_title' => 'University App Revamp', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'University App Revamp', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Cybersecurity Crash Course Week', 'category_name' => 'Technology Innovation'],
            ['idea_title' => 'Cybersecurity Crash Course Week', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Faculty Peer Teaching Program', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Virtual Teaching Resource Center', 'category_name' => 'Education Enhancement'],
            ['idea_title' => 'Virtual Teaching Resource Center', 'category_name' => 'Technology Innovation'],
            ['idea_title' => 'Inclusive Campus Dialogue Series', 'category_name' => 'Equity and Inclusion'],
            ['idea_title' => 'Inclusive Campus Dialogue Series', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Anonymous Well-Being Pulse Check', 'category_name' => 'Equity and Inclusion'],
            ['idea_title' => 'Anonymous Well-Being Pulse Check', 'category_name' => 'Health and Wellness'],
            ['idea_title' => 'Anonymous Well-Being Pulse Check', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Rotating Campus Art Exhibits', 'category_name' => 'Creative Expression'],
            ['idea_title' => 'Rotating Campus Art Exhibits', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Annual Staff Arts Festival', 'category_name' => 'Creative Expression'],
            ['idea_title' => 'Annual Staff Arts Festival', 'category_name' => 'Campus Community'],
            ['idea_title' => 'Annual Staff Arts Festival', 'category_name' => 'Staff Development'],
        ];

        foreach ($ideaCategories as $ideaCategory) {
            $idea = Idea::where('title', $ideaCategory['idea_title'])->first();
            $category = Category::where('name', $ideaCategory['category_name'])->first();

            if ($idea && $category) {
                DB::table('category_idea')->insert([
                    'idea_id' => $idea->id,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}