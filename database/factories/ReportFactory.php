<?php

namespace Database\Factories;

use App\Models\Idea;
use App\Models\ReportType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Report>
 */
class ReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "reason" => $this->faker->paragraph(),
            "is_active" => true,
            "idea_id" => fn () => Idea::inRandomOrder()->first()->id ?? Idea::factory()->create()->id,
            "user_id" => fn () => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
            "report_type_id" => fn () => ReportType::inRandomOrder()->first()->id ?? ReportType::factory()->create()->id,
        ];
    }
}
