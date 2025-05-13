<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@test.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('Super Admin');
    }
}
