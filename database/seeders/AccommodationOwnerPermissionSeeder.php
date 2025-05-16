<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AccommodationOwnerPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = ['Staff', 'Room', 'RoomBooking', 'Guest'];
        $policies = ['view-any', 'view', 'create', 'update', 'delete'];
        $permissions = [];
        
        foreach ($policies as $policy) {
            foreach ($models as $model) {
                $permissions[] = "{$policy} {$model}";
            }
        }
        
        Role::where('name', 'Accommodation Owner')
            ->firstOrFail()
            ->givePermissionTo($permissions);
    }
}
