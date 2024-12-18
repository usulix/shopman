<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Invoice;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InvoiceController
 */
final class InvoiceControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $invoices = Invoice::factory()->count(3)->create();

        $response = $this->get(route('invoices.index'));

        $response->assertOk();
        $response->assertViewIs('invoice.index');
        $response->assertViewHas('invoices');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('invoices.create'));

        $response->assertOk();
        $response->assertViewIs('invoice.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InvoiceController::class,
            'store',
            \App\Http\Requests\InvoiceStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $number = $this->faker->randomNumber();
        $status = $this->faker->word();
        $task = Task::factory()->create();

        $response = $this->post(route('invoices.store'), [
            'number' => $number,
            'status' => $status,
            'task_id' => $task->id,
        ]);

        $invoices = Invoice::query()
            ->where('number', $number)
            ->where('status', $status)
            ->where('task_id', $task->id)
            ->get();
        $this->assertCount(1, $invoices);
        $invoice = $invoices->first();

        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHas('invoice.id', $invoice->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->get(route('invoices.show', $invoice));

        $response->assertOk();
        $response->assertViewIs('invoice.show');
        $response->assertViewHas('invoice');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->get(route('invoices.edit', $invoice));

        $response->assertOk();
        $response->assertViewIs('invoice.edit');
        $response->assertViewHas('invoice');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InvoiceController::class,
            'update',
            \App\Http\Requests\InvoiceUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $invoice = Invoice::factory()->create();
        $number = $this->faker->randomNumber();
        $status = $this->faker->word();
        $task = Task::factory()->create();

        $response = $this->put(route('invoices.update', $invoice), [
            'number' => $number,
            'status' => $status,
            'task_id' => $task->id,
        ]);

        $invoice->refresh();

        $response->assertRedirect(route('invoices.index'));
        $response->assertSessionHas('invoice.id', $invoice->id);

        $this->assertEquals($number, $invoice->number);
        $this->assertEquals($status, $invoice->status);
        $this->assertEquals($task->id, $invoice->task_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->delete(route('invoices.destroy', $invoice));

        $response->assertRedirect(route('invoices.index'));

        $this->assertModelMissing($invoice);
    }
}
