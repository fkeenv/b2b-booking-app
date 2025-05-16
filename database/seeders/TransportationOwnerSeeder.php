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
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john.doe@mailinator.com',
            'password' => bcrypt('password'),
            'created_at' => now(),
        ]);

        $transportation = Transportation::create([
            'name' => 'Transportation Co.',
            'email' => 'transportation.co@mailinator.com',
            'phone' => '+639151630468',
            'website' => 'www.transportation.test',
            'created_at' => now()
        ]);

        Staff::create([
           'user_id' => $user->id,
            'staffable_id' => $transportation->id,
            'staffable_type' => Transportation::class,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => '+63322551385',
            'created_at' => now(),
        ]);

        $user->assignRole('Transportation Owner');
    }
}
