<?php

namespace Tests\Feature;

use App\Filament\Resources\TransportationResource;
use App\Models\Transportation;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class TransportationResourceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
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
}
