<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Users;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UsersController
 */
final class UsersControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $users = Users::factory()->count(3)->create();

        $response = $this->get(route('users.index'));

        $response->assertOk();
        $response->assertViewIs('user.index');
        $response->assertViewHas('users');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('users.create'));

        $response->assertOk();
        $response->assertViewIs('user.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UsersController::class,
            'store',
            \App\Http\Requests\UsersStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();
        $isOwner = $this->faker->boolean();
        $remember_token = $this->faker->uuid();

        $response = $this->post(route('users.store'), [
            'name' => $name,
            'email' => $email,
            'isOwner' => $isOwner,
            'remember_token' => $remember_token,
        ]);

        $users = User::query()
            ->where('name', $name)
            ->where('email', $email)
            ->where('isOwner', $isOwner)
            ->where('remember_token', $remember_token)
            ->get();
        $this->assertCount(1, $users);
        $user = $users->first();

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('user.id', $user->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $user = Users::factory()->create();

        $response = $this->get(route('users.show', $user));

        $response->assertOk();
        $response->assertViewIs('user.show');
        $response->assertViewHas('user');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $user = Users::factory()->create();

        $response = $this->get(route('users.edit', $user));

        $response->assertOk();
        $response->assertViewIs('user.edit');
        $response->assertViewHas('user');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UsersController::class,
            'update',
            \App\Http\Requests\UsersUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $user = Users::factory()->create();
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();
        $isOwner = $this->faker->boolean();
        $remember_token = $this->faker->uuid();

        $response = $this->put(route('users.update', $user), [
            'name' => $name,
            'email' => $email,
            'isOwner' => $isOwner,
            'remember_token' => $remember_token,
        ]);

        $user->refresh();

        $response->assertRedirect(route('users.index'));
        $response->assertSessionHas('user.id', $user->id);

        $this->assertEquals($name, $user->name);
        $this->assertEquals($email, $user->email);
        $this->assertEquals($isOwner, $user->isOwner);
        $this->assertEquals($remember_token, $user->remember_token);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $user = Users::factory()->create();
        $user = User::factory()->create();

        $response = $this->delete(route('users.destroy', $user));

        $response->assertRedirect(route('users.index'));

        $this->assertModelMissing($user);
    }
}
