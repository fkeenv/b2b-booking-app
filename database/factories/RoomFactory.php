<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Accommodation;

/**
 * Factory to generate Room model instances with synced fields for realistic data.
 */
class RoomFactory extends Factory
{
    protected $model = \App\Models\Room::class;

    public function definition()
    {
        // Pick room type first
        $type = $this->faker->randomElement(['single', 'double', 'suite', 'family']);

        // Map capacity based on type
        $capacityMap = [
            'single' => 1,
            'double' => 2,
            'suite' => $this->faker->numberBetween(3, 5),
            'family' => $this->faker->numberBetween(4, 6),
        ];

        // Map price (in cents) based on type
        $priceMap = [
            'single' => $this->faker->numberBetween(5000, 10000),    // $50 - $100
            'double' => $this->faker->numberBetween(8000, 15000),    // $80 - $150
            'suite'  => $this->faker->numberBetween(15000, 40000),   // $150 - $400
            'family' => $this->faker->numberBetween(20000, 50000),   // $200 - $500
        ];

        // Get accommodation or create one
        $accommodation = Accommodation::inRandomOrder()->first() ?? Accommodation::factory()->create();

        // Generate human-readable room code: AC{AccommodationID}-{4 chars}
        $roomCode = $this->generateRoomCode($accommodation->id);

        return [
            'accommodation_id' => $accommodation->id,
            'name' => $this->faker->words(2, true), // e.g., "Deluxe Suite"
            'room_code' => $roomCode,
            'description' => $this->faker->text(200), // longer description
            'image_url' => $this->faker->imageUrl(640, 480, 'rooms', true),
            'type' => $type,
            'capacity' => $capacityMap[$type],
            'price' => $priceMap[$type],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Generate a human-readable room code.
     * Format: AC{AccommodationID}-{4 chars}
     * Characters exclude confusing letters (I, O, L).
     */
    private function generateRoomCode(int $accommodationId): string
    {
        $chars = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789'; // no I, O, L, 0, 1
        $randomPart = '';
        for ($i = 0; $i < 4; $i++) {
            $randomPart .= $chars[random_int(0, strlen($chars) - 1)];
        }

        return 'AC' . $accommodationId . '-' . $randomPart;
    }
}
