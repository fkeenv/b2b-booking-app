<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
use Illuminate\Database\Seeder;

class TransportationOwnerPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $models = ['Staff', 'Vehicle'];
        $policies = ['view-any', 'view', 'create', 'update', 'delete'];
        $permissions = [];
        
        foreach ($policies as $policy) {
            foreach ($models as $model) {
                $permissions[] = "{$policy} {$model}";
            }
        }
        
        Role::where('name', 'Transportation Owner')
            ->firstOrFail()
            ->givePermissionTo($permissions);
    }
}
