<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Contact;
use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContactController
 */
final class ContactControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_displays_view(): void
    {
        $contacts = Contact::factory()->count(3)->create();

        $response = $this->get(route('contacts.index'));

        $response->assertOk();
        $response->assertViewIs('contact.index');
        $response->assertViewHas('contacts');
    }


    #[Test]
    public function create_displays_view(): void
    {
        $response = $this->get(route('contacts.create'));

        $response->assertOk();
        $response->assertViewIs('contact.create');
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContactController::class,
            'store',
            \App\Http\Requests\ContactStoreRequest::class
        );
    }

    #[Test]
    public function store_saves_and_redirects(): void
    {
        $name = $this->faker->name();
        $phone = $this->faker->phoneNumber();
        $email = $this->faker->safeEmail();
        $customer = Customer::factory()->create();

        $response = $this->post(route('contacts.store'), [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'customer_id' => $customer->id,
        ]);

        $contacts = Contact::query()
            ->where('name', $name)
            ->where('phone', $phone)
            ->where('email', $email)
            ->where('customer_id', $customer->id)
            ->get();
        $this->assertCount(1, $contacts);
        $contact = $contacts->first();

        $response->assertRedirect(route('contacts.index'));
        $response->assertSessionHas('contact.id', $contact->id);
    }


    #[Test]
    public function show_displays_view(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->get(route('contacts.show', $contact));

        $response->assertOk();
        $response->assertViewIs('contact.show');
        $response->assertViewHas('contact');
    }


    #[Test]
    public function edit_displays_view(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->get(route('contacts.edit', $contact));

        $response->assertOk();
        $response->assertViewIs('contact.edit');
        $response->assertViewHas('contact');
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContactController::class,
            'update',
            \App\Http\Requests\ContactUpdateRequest::class
        );
    }

    #[Test]
    public function update_redirects(): void
    {
        $contact = Contact::factory()->create();
        $name = $this->faker->name();
        $phone = $this->faker->phoneNumber();
        $email = $this->faker->safeEmail();
        $customer = Customer::factory()->create();

        $response = $this->put(route('contacts.update', $contact), [
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'customer_id' => $customer->id,
        ]);

        $contact->refresh();

        $response->assertRedirect(route('contacts.index'));
        $response->assertSessionHas('contact.id', $contact->id);

        $this->assertEquals($name, $contact->name);
        $this->assertEquals($phone, $contact->phone);
        $this->assertEquals($email, $contact->email);
        $this->assertEquals($customer->id, $contact->customer_id);
    }


    #[Test]
    public function destroy_deletes_and_redirects(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->delete(route('contacts.destroy', $contact));

        $response->assertRedirect(route('contacts.index'));

        $this->assertModelMissing($contact);
    }
}
