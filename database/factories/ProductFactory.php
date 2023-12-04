<?php

namespace Database\Factories;

use App\Models\ProductCategory;
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
            'product_category_id' => ProductCategory::factory()->create(),
            'slug' => fake()->word(),
            'title' => fake()->word(),
            'image' =>  fake()->imageUrl(),
            'description' => fake()->text(),
            'price' => fake()->numberBetween('10', '1000'),
        ];
    }
}
