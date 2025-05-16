<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Closure>
 */
class ClosureFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = now()->addYear();
        $finalDate = (clone $date)->addMonth();

        return [
            'name' => $this->faker->words(3, true),
            'date' => $date,
            'final_date' => $finalDate,
        ];
    }
}
