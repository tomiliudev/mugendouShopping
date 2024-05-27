<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'information' => fake()->realText(),
            'price' => fake()->numberBetween(10, 100000),
            'sortOrder' => fake()->randomNumber(),
            'shopId' => fake()->numberBetween(1, 2),
            'secondaryId' => fake()->numberBetween(1, 9),
            'image1' => fake()->numberBetween(1, 9),
            'image2' => fake()->numberBetween(1, 9),
            'image3' => fake()->numberBetween(1, 9),
            'image4' => fake()->numberBetween(1, 9),
            'isSelling' => fake()->numberBetween(0, 1),
        ];
    }
}
