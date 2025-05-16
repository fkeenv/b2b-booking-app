<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'make' => $this->faker->word(),
            'model' => $this->faker->word(),
            'year' => $this->faker->year(),
            'color' => $this->faker->colorName(),
            'license_plate' => $this->faker->randomNumber(),
        ];
    }
}
