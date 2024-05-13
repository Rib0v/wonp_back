<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\House>
 */
class HouseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->text(20),
            'price' => fake()->numberBetween(300000, 600000),
            'bedrooms' => fake()->numberBetween(3, 6),
            'bathrooms' => fake()->numberBetween(2, 4),
            'storeys' => fake()->numberBetween(1, 2),
            'garages' => fake()->numberBetween(1, 3),
        ];
    }
}
