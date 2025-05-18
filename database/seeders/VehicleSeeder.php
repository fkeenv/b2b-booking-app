<?php

namespace Database\Seeders;

use App\Models\Transportation;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure there are transportation entries to attach vehicles to
        if (Transportation::count() === 0) {
            $this->command->warn('No transportation entries found. Seeding default transportations...');
            Transportation::factory()->count(3)->create();
        }

        // For each transportation, create a few vehicles
        Transportation::all()->each(function ($transportation) {
            Vehicle::factory()
                ->count(5) // adjust as needed
                ->create(['transportation_id' => $transportation->id]);
        });
    }
}
