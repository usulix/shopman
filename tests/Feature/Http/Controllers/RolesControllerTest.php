<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Role;
use App\Models\Roles;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RolesController
 */
final class RolesControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $roles = Roles::factory()->count(3)->create();

        $response = $this->get(route('roles.index'));

        $response->assertOk();
        $response->assertViewIs('role.index');
        $response->assertViewHas('roles');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('roles.create'));

        $response->assertOk();
        $response->assertViewIs('role.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RolesController::class,
            'store',
            \App\Http\Requests\RolesStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();

        $response = $this->post(route('roles.store'), [
            'name' => $name,
        ]);

        $roles = Role::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $roles);
        $role = $roles->first();

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('role.id', $role->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $role = Roles::factory()->create();

        $response = $this->get(route('roles.show', $role));

        $response->assertOk();
        $response->assertViewIs('role.show');
        $response->assertViewHas('role');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $role = Roles::factory()->create();

        $response = $this->get(route('roles.edit', $role));

        $response->assertOk();
        $response->assertViewIs('role.edit');
        $response->assertViewHas('role');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\RolesController::class,
            'update',
            \App\Http\Requests\RolesUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $role = Roles::factory()->create();
        $name = $this->faker->name();

        $response = $this->put(route('roles.update', $role), [
            'name' => $name,
        ]);

        $role->refresh();

        $response->assertRedirect(route('roles.index'));
        $response->assertSessionHas('role.id', $role->id);

        $this->assertEquals($name, $role->name);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $role = Roles::factory()->create();
        $role = Role::factory()->create();

        $response = $this->delete(route('roles.destroy', $role));

        $response->assertRedirect(route('roles.index'));

        $this->assertModelMissing($role);
    }
}
