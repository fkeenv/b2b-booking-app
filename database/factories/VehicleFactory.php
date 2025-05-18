<?php

namespace Database\Factories;

use App\Models\Transportation;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        $vehicleMakes = [
            'Toyota',
            'Ford',
            'Mercedes',
            'Volvo',
            'Honda',
            'BMW',
            'Tesla'
        ];

        $currentYear = now()->year;

        return [
            'transportation_id' => function () {
                return Transportation::inRandomOrder()->first()?->id ?? Transportation::factory();
            }, 
            'make' => $this->faker->randomElement($vehicleMakes),
            'model' => $this->faker->bothify('Model-###'),
            'year' => (string) $this->faker->numberBetween(2015, $currentYear),
            'color' => $this->faker->safeColorName(),
            'license_plate' => strtoupper($this->faker->bothify('???-####')),
        ];
    }
}
