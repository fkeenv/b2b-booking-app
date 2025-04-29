<?php

namespace Tests\Feature;

use App\Filament\Resources\RoomResource;
use App\Models\Accommodation;
use App\Models\Room;
use App\Models\Staff;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RoomResourceTest extends TestCase
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
        $this->get(RoomResource::getUrl('index'))->assertSuccessful();
    }

    public function test_can_list_rooms()
    {
        $accommodation = Accommodation::factory()->create();
        $rooms = Room::factory()
            ->count(10)
            ->state(new Sequence(
                function (Sequence $sequence) use ($accommodation) {
                    return ['accommodation_id' => $accommodation->id];
                }
            ))
            ->create();

        Livewire::test(RoomResource\Pages\ListRooms::class)->assertSee($rooms->pluck('name')->toArray());
    }

    public function test_can_render_create_page()
    {
        $this->get(RoomResource::getUrl('create'))->assertSuccessful();
    }

    public function test_can_create_a_room()
    {
        $accommodation = Accommodation::factory()->make();
        $room = Room::factory()->make([
            'accommodation_id' => $accommodation->id,
        ]);

        $this->assertDatabaseEmpty('rooms');

        Livewire::test(RoomResource\Pages\CreateRoom::class)
            ->set('data.accommodation_id', $room->accommodation_id)
            ->set('data.name', $room->name)
            ->set('data.room_code', $room->room_code)
            ->set('data.description', $room->description)
            ->set('data.type', $room->type)
            ->set('data.capacity', $room->capacity)
            ->set('data.price', $room->price)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseCount('rooms', 1);
        $this->assertDatabaseHas('rooms', [
            'name' => $room->name,
            'room_code' => $room->room_code,
            'description' => $room->description,
            'type' => $room->type,
            'capacity' => $room->capacity,
            'price' => $room->price,
        ]);
    }

    public function test_can_validate_input()
    {
        Livewire::test(RoomResource\Pages\CreateRoom::class)
            ->fillForm([
                'name' => null
            ])
            ->call('create')
            ->assertHasFormErrors();
    }

    public function test_can_update_a_room()
    {
        $accommodation = Accommodation::factory()->create();
        $room = Room::factory()->create([
            'accommodation_id' => $accommodation->id,
        ]);

        Livewire::test(RoomResource\Pages\EditRoom::class, [
            'record' => $room->getRouteKey(),
        ])->assertSuccessful();
    }

    public function test_can_delete_a_room()
    {
        $accommodation = Accommodation::factory()->create();
        $room = Room::factory()->create([
            'accommodation_id' => $accommodation->id,
        ]);

        Livewire::test(RoomResource\Pages\EditRoom::class, [
            'record' => $room->getRouteKey(),
        ])
            ->callAction(DeleteAction::class);

        $this->assertModelMissing($room);
    }
}
