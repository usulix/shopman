<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Account;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
final class AccountControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $accounts = Account::factory()->count(3)->create();

        $response = $this->get(route('accounts.index'));

        $response->assertOk();
        $response->assertViewIs('account.index');
        $response->assertViewHas('accounts');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('accounts.create'));

        $response->assertOk();
        $response->assertViewIs('account.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccountController::class,
            'store',
            \App\Http\Requests\AccountStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();

        $response = $this->post(route('accounts.store'), [
            'name' => $name,
        ]);

        $accounts = Account::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $accounts);
        $account = $accounts->first();

        $response->assertRedirect(route('accounts.index'));
        $response->assertSessionHas('account.id', $account->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $account = Account::factory()->create();

        $response = $this->get(route('accounts.show', $account));

        $response->assertOk();
        $response->assertViewIs('account.show');
        $response->assertViewHas('account');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $account = Account::factory()->create();

        $response = $this->get(route('accounts.edit', $account));

        $response->assertOk();
        $response->assertViewIs('account.edit');
        $response->assertViewHas('account');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AccountController::class,
            'update',
            \App\Http\Requests\AccountUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $account = Account::factory()->create();
        $name = $this->faker->name();

        $response = $this->put(route('accounts.update', $account), [
            'name' => $name,
        ]);

        $account->refresh();

        $response->assertRedirect(route('accounts.index'));
        $response->assertSessionHas('account.id', $account->id);

        $this->assertEquals($name, $account->name);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $account = Account::factory()->create();

        $response = $this->delete(route('accounts.destroy', $account));

        $response->assertRedirect(route('accounts.index'));

        $this->assertModelMissing($account);
    }
}
