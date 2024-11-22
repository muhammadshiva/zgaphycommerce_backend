<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artwork>
 */
class ArtworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'artwork_code' => fake()->sentence(5),
            'title' => fake()->sentence(5),
            'description' => fake()->paragraph(2),
            'price' => fake()->randomFloat(2, 10, 1000),
            'category_id' => rand(1, 10),
            'image' => 'default_artwork.jpg',
            'qr_code_url' => null,
            'qr_code_image' => null,
            'frame_width' => 0,
            'frame_height' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
