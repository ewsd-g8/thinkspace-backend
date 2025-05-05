<?php

namespace Database\Factories;

use App\Models\Closure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Idea>
 */
class IdeaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(3, true),
            'is_anonymous' => $this->faker->boolean(50),
            'closure_id' => fn () => Closure::inRandomOrder()->first()->id ?? Closure::factory()->create()->id,
            'user_id' => fn () => User::inRandomOrder()->first()->id ?? User::factory()->create()->id,
        ];
    }
}
