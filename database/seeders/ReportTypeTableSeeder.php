<?php

namespace Database\Seeders;

use App\Models\ReportType;
use Illuminate\Database\Seeder;

class ReportTypeTableSeeder extends Seeder
{
    public function run()
    {
        $reportTypes = [
            [
                "name" => "Harassment",
                "description" => "This report type is for incidents involving unwelcome behavior that creates a hostile or intimidating environment. Examples include verbal abuse, bullying, or repeated unwanted advances that disrupt the safety and well-being of individuals on campus.",
            ],
            [
                "name" => "Spam",
                "description" => "Use this category to report unsolicited or repetitive messages, posts, or content that clogs communication channels. This includes mass emails, irrelevant advertisements, or automated bot activity that interferes with normal campus interactions.",
            ],
            [
                "name" => "Inappropriate Content",
                "description" => "This type covers material that violates campus standards, such as explicit images, offensive language, or content promoting hate or discrimination. It’s for anything that doesn’t align with our community values of respect and inclusion.",
            ],
            [
                "name" => "Misinformation",
                "description" => "Report instances where false or misleading information is shared, potentially causing confusion or harm. This could include rumors about campus events, fake policy updates, or inaccurate academic claims that mislead the community.",
            ],
            [
                "name" => "Threat",
                "description" => "This category is for reporting direct or implied threats of violence, harm, or severe disruption. It includes physical threats, menacing messages, or any behavior that makes individuals feel unsafe or targeted on campus.",
            ],
        ];

        foreach ($reportTypes as $reportType) {
            ReportType::create([
                'name' => $reportType['name'],
                'description' => $reportType['description'],
            ]);
        }
    }
}