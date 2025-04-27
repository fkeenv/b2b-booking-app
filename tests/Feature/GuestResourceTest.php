<?php

namespace Tests\Feature;

use App\Filament\Resources\GuestResource;
use App\Models\Accommodation;
use App\Models\Guest;
use App\Models\Staff;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class GuestResourceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();

        /** @var User $user */
        $user = User::factory()->create();
        $accommodation = Accommodation::factory()->create();
        Staff::factory()->create([
            'user_id' => $user->id,
            'staffable_type' => Accommodation::class,
            'staffable_id' => $accommodation->id,
        ]);
        $role = Role::create(['name' => 'Super Admin']);
        $user->assignRole($role);
        $this->actingAs($user);
    }

    public function test_can_render_page()
    {
        $this->get(GuestResource::getUrl('index'))->assertSuccessful();
    }

    public function test_can_list_guests()
    {
        $accommodation = Accommodation::factory()->create();
        $guests = Guest::factory()
            ->count(10)
            ->state(new Sequence(
                function (Sequence $sequence) use ($accommodation) {
                    return ['accommodation_id' => $accommodation->id];
            }
        ))
            ->create();

        Livewire::test(GuestResource\Pages\ListGuests::class)->assertSee($guests->pluck('name')->toArray());
    }

    public function test_can_render_create_page()
    {
        $this->get(GuestResource::getUrl('create'))->assertSuccessful();
    }

    public function test_can_create_a_guest()
    {
        $accommodation = Accommodation::factory()->make();
        $guest = Guest::factory()->make([
            'accommodation_id' => $accommodation->id,
        ]);

        $this->assertDatabaseEmpty('guests');

        Livewire::test(GuestResource\Pages\CreateGuest::class)
            ->set('data.accommodation_id', $guest->accommodation_id)
            ->set('data.name', $guest->name)
            ->set('data.email', $guest->email)
            ->set('data.phone', $guest->phone)
            ->set('data.gender', $guest->gender)
            ->set('data.date_of_birth', $guest->date_of_birth)
            ->set('data.address', $guest->address)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('guests', 1);
        $this->assertDatabaseHas('guests', [
            'name' => $guest->name,
            'email' => $guest->email,
            'phone' => $guest->phone,
            'gender' => $guest->gender,
            'date_of_birth' => $guest->date_of_birth,
            'address' => $guest->address,
        ]);
    }

    public function test_can_validate_input()
    {
        Livewire::test(GuestResource\Pages\CreateGuest::class)
            ->fillForm([
                'name' => null
            ])
            ->call('create')
            ->assertHasFormErrors();
    }

    public function test_can_update_a_guest()
    {
        $accommodation = Accommodation::factory()->create();
        $guest = Guest::factory()->create([
            'accommodation_id' => $accommodation->id,
        ]);

        Livewire::test(GuestResource\Pages\EditGuest::class, [
            'record' => $guest->getRouteKey(),
        ])->assertSuccessful();
    }

    public function test_can_delete_a_guest()
    {
        $accommodation = Accommodation::factory()->create();
        $guest = Guest::factory()->create([
            'accommodation_id' => $accommodation->id,
        ]);

        Livewire::test(GuestResource\Pages\EditGuest::class, [
            'record' => $guest->getRouteKey(),
        ])
            ->callAction(DeleteAction::class);

        $this->assertModelMissing($guest);
    }
}
