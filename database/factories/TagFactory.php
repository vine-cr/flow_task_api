<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private array $colors = [
        '#FF5733', '#33FF57', '#3357FF', '#FF33A8',
        '#FFD700', '#00CED1', '#FF6347', '#8A2BE2',
    ];

    public function definition(): array
    {
        return [
            'name'  => fake()->unique()->word(),
            'color' => fake()->randomElement($this->colors),
        ];
    }
}
