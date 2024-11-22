<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, 10),
            'artwork_id' => rand(1, 10),
            'total_price' => fake()->randomFloat(2, 10, 1000),
            'status' => fake()->randomElement(['waiting', 'approved', 'cancelled']),
        ];
    }
}
