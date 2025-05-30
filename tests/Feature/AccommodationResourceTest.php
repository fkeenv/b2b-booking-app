<?php

namespace Tests\Feature;

use App\Filament\Resources\AccommodationResource;
use App\Filament\Resources\AccommodationResource\Pages\CreateAccommodation;
use App\Filament\Resources\AccommodationResource\Pages\EditAccommodation;
use App\Filament\Resources\AccommodationResource\Pages\ListAccommodations;
use App\Models\Accommodation;
use App\Models\Staff;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AccommodationResourceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create();
        $role = Role::create(['name' => 'Super Admin']);
        $user->assignRole($role);
        $this->actingAs($user);
    }

    public function test_can_render_page()
    {
        $this->get(AccommodationResource::getUrl('index'))->assertSuccessful();
    }

    public function test_can_list_accommodations()
    {
        $accommodations = Accommodation::factory()->count(10)->create();

        Livewire::test(ListAccommodations::class)->assertSee($accommodations->pluck('name')->toArray());
    }

    public function test_can_render_create_page()
    {
        $this->get(AccommodationResource::getUrl('create'))->assertSuccessful();
    }

    public function test_can_create_an_accommodation()
    {
        $accommodation = Accommodation::factory()->make();

        $this->assertDatabaseEmpty('accommodations');

        Livewire::test(CreateAccommodation::class)
            ->set('data.name', $accommodation->name)
            ->set('data.website', $accommodation->website)
            ->set('data.email', $accommodation->email)
            ->set('data.contact', $accommodation->contact)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('accommodations', 1);
        $this->assertDatabaseHas('accommodations', [
            'name' => $accommodation->name,
            'website' => $accommodation->website,
            'email' => $accommodation->email,
            'contact' => $accommodation->contact,
        ]);
    }

    public function test_can_validate_input()
    {
        Livewire::test(CreateAccommodation::class)
            ->fillForm([
                'name' => null
            ])
            ->call('create')
            ->assertHasFormErrors();
    }

    public function test_can_update_an_accommodation()
    {
        $accommodation = Accommodation::factory()->create();

        Livewire::test(EditAccommodation::class, [
            'record' => $accommodation->getRouteKey(),
        ])->assertSuccessful();
    }

    public function test_can_delete_an_accommodation()
    {
        $accommodation = Accommodation::factory()->create();

        Livewire::test(EditAccommodation::class, [
            'record' => $accommodation->getRouteKey(),
        ])
            ->callAction(DeleteAction::class);

        $this->assertModelMissing($accommodation);
    }

    public function test_can_render_staffs_relation_manager()
    {
        $accommodation = Accommodation::factory()->create();
        Staff::factory()->count(10)->sequence(function () use ($accommodation) {
            return [
                'staffable_id' => $accommodation->id,
                'staffable_type' => Accommodation::class,
            ];
        });

        Livewire::test(AccommodationResource\RelationManagers\StaffsRelationManager::class, [
            'ownerRecord' => $accommodation,
            'pageClass' => EditAccommodation::class,
        ])
            ->assertSuccessful();
    }

    public function test_can_add_staff_through_relation_manager()
    {
        $accommodation = Accommodation::factory()->create();
        $data = [
            'staffable_id' => $accommodation->id,
            'staffable_type' => Accommodation::class,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
        ];

        Livewire::test(AccommodationResource\RelationManagers\StaffsRelationManager::class, [
            'ownerRecord' => $accommodation,
            'pageClass' => EditAccommodation::class,
        ])
            ->callTableAction('create', data: $data);

        $this->assertDatabaseHas('staffs', $data);
    }
}
