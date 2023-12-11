<?php

namespace Database\Factories;

use App\Enums\StatusOrder;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory()->create(),
            'total_price' => fake()->numberBetween('10', '1000'),
            'quantity' => fake()->numberBetween('10', '80'),
            'status' => fake()->randomElement(StatusOrder::lowercaseOptions())
        ];
    }
}
