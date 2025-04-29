<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'room_code' => $this->faker->unique()->word(),
            'description' => $this->faker->sentence(),
            'image_url' => $this->faker->imageUrl(),
            'type' => $this->faker->randomElement(['single', 'double', 'suite', 'family']),
            'capacity' => $this->faker->numberBetween(1, 4),
            'price' => $this->faker->numberBetween(1000, 50000), // Price in cents
        ];
    }
}
