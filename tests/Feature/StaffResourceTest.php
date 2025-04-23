<?php

namespace Tests\Feature;

use App\Filament\Resources\AccommodationResource\Pages\EditAccommodation;
use App\Filament\Resources\TransportationResource;
use App\Filament\Resources\AccommodationResource;
use App\Filament\Resources\StaffResource;
use App\Filament\Resources\TransportationResource\Pages\EditTransportation;
use App\Models\Accommodation;
use App\Models\Staff;
use App\Models\Transportation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StaffResourceTest extends TestCase
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
        $this->get(StaffResource::getUrl('index'))->assertSuccessful();
    }

    public function test_can_list_staffs()
    {
        $users = User::factory(3)->create();
        $transportation = Transportation::factory()->create();
        $users->each(function ($user) use ($transportation) {
           Staff::factory()->create([
               'user_id' => $user->id,
               'staffable_id' => $transportation->id,
               'staffable_type' => Transportation::class,
           ]);
        });

        $staffs = Staff::query()->limit(10)->get()->pluck('name')->toArray();

        Livewire::test(StaffResource\Pages\ListStaff::class)->assertSee($staffs);
    }

    public function test_can_retrieve_staff()
    {
        $user = User::factory()->create();
        $transportation = Transportation::factory()->create();
        $staff = Staff::factory()->create([
            'user_id' => $user->id,
            'staffable_id' => $transportation->id,
            'staffable_type' => Transportation::class,
        ]);

        Livewire::test(StaffResource\Pages\EditStaff::class, [
            'record' => $staff->getRouteKey()
        ])
            ->assertFormSet([
                'name' => $staff->name,
                'phone' => $staff->phone,
            ]);
    }

    public function test_can_update_staff()
    {
        $user = User::factory()->create();
        $transportation = Transportation::factory()->create();
        $staff = Staff::factory()->create([
            'user_id' => $user->id,
            'staffable_id' => $transportation->id,
            'staffable_type' => Transportation::class,
        ]);
        $editData = [
            'name' => $this->faker()->name,
            'phone' => $this->faker()->phoneNumber,
        ];

        Livewire::test(StaffResource\Pages\EditStaff::class, [
            'record' => $staff->getRouteKey(),
        ])
            ->fillForm($editData)
            ->call('save')
            ->assertHasNoErrors();

        $staff->refresh();
        $this->assertSame($staff->name, $editData['name']);
        $this->assertSame($staff->phone, $editData['phone']);
    }
}
