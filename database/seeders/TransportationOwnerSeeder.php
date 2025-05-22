<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\Transportation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TransportationOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create();

        $transportation = Transportation::create([
            'name' => 'Transportation Co.',
            'email' => 'transportation.co@mailinator.com',
            'phone' => '+639141234567',
            'website' => 'www.transportation.test',
            'created_at' => now()
        ]);

        Staff::create([
           'user_id' => $user->id,
            'staffable_id' => $transportation->id,
            'staffable_type' => Transportation::class,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => '+639141234567',
            'created_at' => now(),
        ]);

        $user->assignRole('Transportation Owner');
    }
}
