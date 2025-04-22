<?php

namespace Tests\Feature;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Filament\Resources\UserResource\Pages\EditUser;
use App\Filament\Resources\UserResource\Pages\ListUsers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Nette\Schema\Expect;
use Tests\TestCase;

class UserResourceTest extends TestCase
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
        $this->get(UserResource::getUrl('index'))->assertSuccessful();
    }

    public function test_can_list_users()
    {
        $users = User::factory()->count(3)->create();

        Livewire::test(ListUsers::class)
            ->assertCanSeeTableRecords($users);
    }

    public function test_can_render_create_page()
    {
        $this->get(UserResource::getUrl('create'))->assertSuccessful();
    }

    public function test_can_create_user()
    {
        $password = $this->faker->password(8);
        $data = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $password,
            'password_confirmation' => $password,
        ];

        Livewire::test(CreateUser::class)
            ->fillForm($data)
            ->call('create')
            ->assertHasNoErrors();

        $this->assertDatabaseHas(User::class, [
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
    }

    public function test_can_validate_input()
    {
        Livewire::test(CreateUser::class)
            ->fillForm([
                'name' => null
            ])
            ->call('create')
            ->assertHasFormErrors();
    }

    public function test_can_retrieve_user()
    {
        $user = User::factory()->create();

        Livewire::test(EditUser::class, [
            'record' => $user->getRouteKey()
        ])
            ->assertFormSet([
               'name' => $user->name,
               'email' => $user->email,
            ]);
    }

    public function test_can_update_user()
    {
        $user = User::factory()->create();
        $newData = [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
        ];

        Livewire::test(EditUser::class, [
            'record' => $user->getRouteKey()
        ])
            ->fillForm([
                'name' => $newData['name'],
                'email' => $newData['email'],
            ])
            ->call('save')
            ->assertHasNoFormErrors();

        $user->refresh();
        $this->assertEquals($newData['name'], $user->name);
        $this->assertEquals($newData['email'], $user->email);
    }

    public function test_can_mark_user_as_verified()
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        Livewire::test(EditUser::class, [
            'record' => $user->getRouteKey()
        ])
            ->assertActionVisible('verify_email')
            ->callAction('verify_email')
            ->assertHasNoActionErrors();

        $user->refresh();
        $this->assertNotNull($user->email_verified_at);
    }

    public function test_can_mark_user_as_unverified()
    {
        $user = User::factory()->create();

        Livewire::test(EditUser::class, [
            'record' => $user->getRouteKey()
        ])
            ->assertActionVisible('unverify_email')
            ->callAction('unverify_email')
            ->assertHasNoActionErrors();

        $user->refresh();
        $this->assertNull($user->email_verified_at);
    }
}
