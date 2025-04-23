<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'item_name'     => fake()->word(),
            'price'         => fake()->numberBetween(100, 2000),
            'stocks'        => fake()->numberBetween(0, 500),
            'sold'          => fake()->numberBetween(0, 200),
            'image'         => fake()->imageUrl(640, 470, 'products'),
            'item_status'   => fake()->randomElement([
                'in_stock',
                'out_of_stock'
            ])
        ];
    }
}
