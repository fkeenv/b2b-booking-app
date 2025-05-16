<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'Super Admin', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Accommodation Owner', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Transportation Owner', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
