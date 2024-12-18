<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Invoice;
use App\Models\LineItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LineItemController
 */
final class LineItemControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $lineItems = LineItem::factory()->count(3)->create();

        $response = $this->get(route('line-items.index'));

        $response->assertOk();
        $response->assertViewIs('lineItem.index');
        $response->assertViewHas('lineItems');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('line-items.create'));

        $response->assertOk();
        $response->assertViewIs('lineItem.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LineItemController::class,
            'store',
            \App\Http\Requests\LineItemStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $description = $this->faker->text();
        $price = $this->faker->randomNumber();
        $invoice = Invoice::factory()->create();

        $response = $this->post(route('line-items.store'), [
            'description' => $description,
            'price' => $price,
            'invoice_id' => $invoice->id,
        ]);

        $lineItems = LineItem::query()
            ->where('description', $description)
            ->where('price', $price)
            ->where('invoice_id', $invoice->id)
            ->get();
        $this->assertCount(1, $lineItems);
        $lineItem = $lineItems->first();

        $response->assertRedirect(route('lineItems.index'));
        $response->assertSessionHas('lineItem.id', $lineItem->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $lineItem = LineItem::factory()->create();

        $response = $this->get(route('line-items.show', $lineItem));

        $response->assertOk();
        $response->assertViewIs('lineItem.show');
        $response->assertViewHas('lineItem');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $lineItem = LineItem::factory()->create();

        $response = $this->get(route('line-items.edit', $lineItem));

        $response->assertOk();
        $response->assertViewIs('lineItem.edit');
        $response->assertViewHas('lineItem');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LineItemController::class,
            'update',
            \App\Http\Requests\LineItemUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $lineItem = LineItem::factory()->create();
        $description = $this->faker->text();
        $price = $this->faker->randomNumber();
        $invoice = Invoice::factory()->create();

        $response = $this->put(route('line-items.update', $lineItem), [
            'description' => $description,
            'price' => $price,
            'invoice_id' => $invoice->id,
        ]);

        $lineItem->refresh();

        $response->assertRedirect(route('lineItems.index'));
        $response->assertSessionHas('lineItem.id', $lineItem->id);

        $this->assertEquals($description, $lineItem->description);
        $this->assertEquals($price, $lineItem->price);
        $this->assertEquals($invoice->id, $lineItem->invoice_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $lineItem = LineItem::factory()->create();

        $response = $this->delete(route('line-items.destroy', $lineItem));

        $response->assertRedirect(route('lineItems.index'));

        $this->assertModelMissing($lineItem);
    }
}
