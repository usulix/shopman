<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use App\Models\Unit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\UnitController
 */
final class UnitControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $units = Unit::factory()->count(3)->create();

        $response = $this->get(route('units.index'));

        $response->assertOk();
        $response->assertViewIs('unit.index');
        $response->assertViewHas('units');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('units.create'));

        $response->assertOk();
        $response->assertViewIs('unit.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UnitController::class,
            'store',
            \App\Http\Requests\UnitStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $customer = Customer::factory()->create();

        $response = $this->post(route('units.store'), [
            'name' => $name,
            'customer_id' => $customer->id,
        ]);

        $units = Unit::query()
            ->where('name', $name)
            ->where('customer_id', $customer->id)
            ->get();
        $this->assertCount(1, $units);
        $unit = $units->first();

        $response->assertRedirect(route('units.index'));
        $response->assertSessionHas('unit.id', $unit->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $unit = Unit::factory()->create();

        $response = $this->get(route('units.show', $unit));

        $response->assertOk();
        $response->assertViewIs('unit.show');
        $response->assertViewHas('unit');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $unit = Unit::factory()->create();

        $response = $this->get(route('units.edit', $unit));

        $response->assertOk();
        $response->assertViewIs('unit.edit');
        $response->assertViewHas('unit');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\UnitController::class,
            'update',
            \App\Http\Requests\UnitUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $unit = Unit::factory()->create();
        $name = $this->faker->name();
        $customer = Customer::factory()->create();

        $response = $this->put(route('units.update', $unit), [
            'name' => $name,
            'customer_id' => $customer->id,
        ]);

        $unit->refresh();

        $response->assertRedirect(route('units.index'));
        $response->assertSessionHas('unit.id', $unit->id);

        $this->assertEquals($name, $unit->name);
        $this->assertEquals($customer->id, $unit->customer_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $unit = Unit::factory()->create();

        $response = $this->delete(route('units.destroy', $unit));

        $response->assertRedirect(route('units.index'));

        $this->assertModelMissing($unit);
    }
}
