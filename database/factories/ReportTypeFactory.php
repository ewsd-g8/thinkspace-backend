<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ReportType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReportType>
 */
class ReportTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "name" => $this->faker->word(),
            "description" => $this->faker->paragraph(),
        ];
    }
}
