<?php

namespace Tests\Feature;

use App\Models\Staff;
use App\Models\Transportation;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;
use App\Filament\Resources\StaffResource;

class AttachVehicleToStaffTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        $permissions = ['view-any Vehicle', 'view Vehicle', 'create Vehicle', 'update Vehicle', 'delete Vehicle'];

        /** @var User $user */
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Transportation Owner']);

        foreach ($permissions as $permission) {
            $permission = Permission::create(['name' => $permission]);
            $role->givePermissionTo($permission);
        }

        $user->assignRole($role);
        $this->actingAs($user);
    }

    public function test_can_render_roles_relation_manager()
    {
        $user = User::factory()->create();
        $transportation = Transportation::factory()->create();
        $staff = Staff::factory()->create([
            'user_id' => $user->id,
            'staffable_id' => $transportation->id,
            'staffable_type' => Transportation::class,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $this->faker->phoneNumber,
        ]);

        Livewire::test(StaffResource\RelationManagers\VehiclesRelationManager::class, [
            'ownerRecord' => $staff,
            'pageClass' => StaffResource\Pages\EditStaff::class,
        ])
            ->assertSuccessful();
    }

    public function test_can_list_vehicles_in_staff_edit_page()
    {
        $user = User::factory()->create();
        $transportation = Transportation::factory()->create();
        $staff = Staff::factory()->create([
            'user_id' => $user->id,
            'staffable_id' => $transportation->id,
            'staffable_type' => Transportation::class,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $this->faker->phoneNumber,
        ]);
        $vehicles = Vehicle::factory(3)->sequence(function () use ($transportation) {
            return [
              'transportation_id' => $transportation->id,
            ];
        })->create();
        $vehicleIds = $vehicles->pluck('id')->toArray();
        $staff->vehicles()->attach($vehicleIds, [
            'starts_at' => now(),
            'ends_at' => now()->addDay(),
        ]);

        Livewire::test(StaffResource\RelationManagers\VehiclesRelationManager::class, [
            'ownerRecord' => $staff,
            'pageClass' => StaffResource\Pages\EditStaff::class,
        ])
            ->assertCanSeeTableRecords($staff->vehicles);
    }

    public function test_can_attach_vehicle_to_staff_in_staff_edit_page()
    {
        $user = User::factory()->create();
        $transportation = Transportation::factory()->create();
        $staff = Staff::factory()->create([
            'user_id' => $user->id,
            'staffable_id' => $transportation->id,
            'staffable_type' => Transportation::class,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $this->faker->phoneNumber,
        ]);
        $vehicle = Vehicle::factory()->create([
            'transportation_id' => $transportation->id,
        ]);
        $data = [
            'recordId' => $vehicle->id,
            'starts_at' => now(),
            'ends_at' => now()->addDay(),
        ];

        Livewire::test(StaffResource\RelationManagers\VehiclesRelationManager::class, [
            'ownerRecord' => $staff,
            'pageClass' => StaffResource\Pages\EditStaff::class,
        ])
            ->callTableAction('attach', data: $data);

        $this->assertDatabaseHas('staff_vehicle', data: [
            'vehicle_id' => $vehicle->id,
            'staff_id' => $staff->id,
        ]);
    }
}
