<?php

namespace Tests\Feature;

use App\Filament\Resources\TransportationResource;
use App\Filament\Resources\TransportationResource\Pages\EditTransportation;
use App\Models\Staff;
use App\Models\Transportation;
use App\Models\User;
use App\Models\Vehicle;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TransportationResourceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);
    }

    public function test_can_render_page()
    {
        $this->get(TransportationResource::getUrl('index'))->assertSuccessful();
    }

    public function test_can_list_transportations()
    {
        $transportations = Transportation::factory()->count(10)->create();

        Livewire::test(TransportationResource\Pages\ListTransportations::class)->assertSee($transportations->pluck('name')->toArray());
    }

    public function test_can_render_create_page()
    {
        $this->get(TransportationResource::getUrl('create'))->assertSuccessful();
    }

    public function test_can_create_an_transportation()
    {
        $transportation = Transportation::factory()->make();

        $this->assertDatabaseEmpty('transportations');

        Livewire::test(TransportationResource\Pages\CreateTransportation::class)
            ->set('data.name', $transportation->name)
            ->set('data.website', $transportation->website)
            ->set('data.email', $transportation->email)
            ->set('data.phone', $transportation->phone)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('transportations', 1);
        $this->assertDatabaseHas('transportations', [
            'name' => $transportation->name,
            'website' => $transportation->website,
            'email' => $transportation->email,
            'phone' => $transportation->phone,
        ]);
    }

    public function test_can_validate_input()
    {
        Livewire::test(TransportationResource\Pages\CreateTransportation::class)
            ->fillForm([
                'name' => null
            ])
            ->call('create')
            ->assertHasFormErrors();
    }

    public function test_can_update_an_transportation()
    {
        $transportation = Transportation::factory()->create();

        Livewire::test(TransportationResource\Pages\EditTransportation::class, [
            'record' => $transportation->getRouteKey(),
        ])->assertSuccessful();
    }

    public function test_can_delete_an_transportation()
    {
        $transportation = Transportation::factory()->create();

        Livewire::test(TransportationResource\Pages\EditTransportation::class, [
            'record' => $transportation->getRouteKey(),
        ])
            ->callAction(DeleteAction::class);

        $this->assertModelMissing($transportation);
    }

    public function test_can_render_staffs()
    {
        $transportation = Transportation::factory()->create();
        Staff::factory()->count(10)->sequence(function () use ($transportation) {
            return [
                'staffable_id' => $transportation->id,
                'staffable_type' => Transportation::class,
            ];
        });

        Livewire::test(TransportationResource\RelationManagers\StaffsRelationManager::class, [
            'ownerRecord' => $transportation,
            'pageClass' => EditTransportation::class,
        ])
            ->assertSuccessful();
    }

    public function test_can_add_staff_through_relation_manager()
    {
        $transportation = Transportation::factory()->create();
        $data = [
          'staffable_id' => $transportation->id,
          'staffable_type' => Transportation::class,
          'name' => $this->faker->name,
          'email' => $this->faker->unique()->safeEmail,
          'phone' => $this->faker->phoneNumber,
        ];

        Livewire::test(TransportationResource\RelationManagers\StaffsRelationManager::class, [
            'ownerRecord' => $transportation,
            'pageClass' => EditTransportation::class,
        ])
            ->callTableAction('create', data: $data);

        $this->assertDatabaseHas('staffs', $data);
    }

    public function test_can_render_vehicles()
    {
        $transportation = Transportation::factory()->create();
        Vehicle::factory()->count(10)->sequence(function () use ($transportation) {
            return [
                'transportation_id' => $transportation->id,
            ];
        });

        Livewire::test(TransportationResource\RelationManagers\VehiclesRelationManager::class, [
            'ownerRecord' => $transportation,
            'pageClass' => EditTransportation::class,
        ])
            ->assertSuccessful();
    }

    public function test_can_add_vehicle_through_relation_manager()
    {
        $transportation = Transportation::factory()->create();

        $data = [
            'transportation_id' => $transportation->id,
            'make' => 'Toyota',
            'model' => 'Corolla',
            'year' => '2020',
            'color' => 'Red',
            'license_plate' => 'XYZ1234'
        ];

        Livewire::test(TransportationResource\RelationManagers\VehiclesRelationManager::class, [
            'ownerRecord' => $transportation,
            'pageClass' => EditTransportation::class,
        ])
            ->callTableAction('create', data: $data);

        $this->assertDatabaseHas('vehicles', $data);
    }
}
