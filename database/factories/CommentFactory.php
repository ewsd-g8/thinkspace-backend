<?php

namespace Database\Factories;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph(),
            'idea_id' => fn () => Idea::inRandomOrder()->first()->id ?? Idea::factory()->create()->id,
            'user_id' => fn () => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
        ];
    }
}
