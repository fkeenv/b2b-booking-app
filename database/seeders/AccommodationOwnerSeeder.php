<?php

namespace Database\Seeders;

use App\Models\Accommodation;
use App\Models\Staff;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccommodationOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        $accommodation = Accommodation::create([
            'name' => 'Accommodation Co.',
            'email' => 'accommodation.co@mailinator.com',
            'contact' => '+639123456789',
            'website' => 'www.accommodation.test',
            'created_at' => now()
        ]);

        Staff::create([
            'user_id' => $user->id,
            'staffable_id' => $accommodation->id,
            'staffable_type' => Accommodation::class,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => '+639123456789',
            'created_at' => now(),
        ]);

        $user->assignRole('Accommodation Owner');
    }
}
