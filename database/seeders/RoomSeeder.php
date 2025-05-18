<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Accommodation;

/**
 * Seeder to generate Room records associated with existing Accommodations.
 */
class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * For each accommodation, creates between 1 to 7 rooms.
     * Skips seeding if no accommodations exist.
     *
     * @return void
     */
    public function run(): void
    {
        $accommodations = Accommodation::all();

        if ($accommodations->isEmpty()) {
            $this->command->info('No accommodations found; skipping Room seeding.');
            return;
        }

        foreach ($accommodations as $accommodation) {
            // Create 1 to 7 rooms per accommodation
            Room::factory()
                ->count(rand(1, 7))
                ->create([
                    'accommodation_id' => $accommodation->id,
                ]);
        }
    }
}
