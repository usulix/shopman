<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Part;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PartController
 */
final class PartControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $parts = Part::factory()->count(3)->create();

        $response = $this->get(route('parts.index'));

        $response->assertOk();
        $response->assertViewIs('part.index');
        $response->assertViewHas('parts');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('parts.create'));

        $response->assertOk();
        $response->assertViewIs('part.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PartController::class,
            'store',
            \App\Http\Requests\PartStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $number = $this->faker->word();
        $name = $this->faker->name();
        $price = $this->faker->randomNumber();
        $received = $this->faker->boolean();

        $response = $this->post(route('parts.store'), [
            'number' => $number,
            'name' => $name,
            'price' => $price,
            'received' => $received,
        ]);

        $parts = Part::query()
            ->where('number', $number)
            ->where('name', $name)
            ->where('price', $price)
            ->where('received', $received)
            ->get();
        $this->assertCount(1, $parts);
        $part = $parts->first();

        $response->assertRedirect(route('parts.index'));
        $response->assertSessionHas('part.id', $part->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $part = Part::factory()->create();

        $response = $this->get(route('parts.show', $part));

        $response->assertOk();
        $response->assertViewIs('part.show');
        $response->assertViewHas('part');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $part = Part::factory()->create();

        $response = $this->get(route('parts.edit', $part));

        $response->assertOk();
        $response->assertViewIs('part.edit');
        $response->assertViewHas('part');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PartController::class,
            'update',
            \App\Http\Requests\PartUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $part = Part::factory()->create();
        $number = $this->faker->word();
        $name = $this->faker->name();
        $price = $this->faker->randomNumber();
        $received = $this->faker->boolean();

        $response = $this->put(route('parts.update', $part), [
            'number' => $number,
            'name' => $name,
            'price' => $price,
            'received' => $received,
        ]);

        $part->refresh();

        $response->assertRedirect(route('parts.index'));
        $response->assertSessionHas('part.id', $part->id);

        $this->assertEquals($number, $part->number);
        $this->assertEquals($name, $part->name);
        $this->assertEquals($price, $part->price);
        $this->assertEquals($received, $part->received);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $part = Part::factory()->create();

        $response = $this->delete(route('parts.destroy', $part));

        $response->assertRedirect(route('parts.index'));

        $this->assertModelMissing($part);
    }
}
