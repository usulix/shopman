<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Models\Contact;
use App\Models\Customer;
use Auth;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function index(Request $request)
    {

        $contacts = Contact::paginate(10);

        return Inertia::render('Contacts/Index', compact('contacts'));
    }

    public function create(Request $request)
    {
        $userAccounts = DB::table("account_user as au")
            ->join('accounts as a','au.account_id', '=', 'a.id')
            ->where('user_id', Auth::id())
            ->pluck('account_id')->toArray();
        $customers = Customer::with('account')->whereIn('account_id', $userAccounts)->get();

        return Inertia::render('Contacts/Create', compact('customers'));
    }

    public function store(ContactStoreRequest $request): RedirectResponse
    {
        $contact = Contact::create($request->validated());

        $request->session()->flash('contact.id', $contact->id);

        return to_route('contacts.index');
    }

    public function show(Request $request, Contact $contact): View
    {
        return view('contact.show', compact('contact'));
    }

    public function edit(Request $request, Contact $contact)
    {
        $contact->load('customer');
        $userAccounts = DB::table("account_user as au")
            ->join('accounts as a','au.account_id', '=', 'a.id')
            ->where('user_id', Auth::id())
            ->pluck('account_id')->toArray();
        $customers = Customer::with('account')->whereIn('account_id', $userAccounts)->get();
        return Inertia::render('Contacts/Edit', compact('contact', 'customers'));
    }

    public function update(ContactUpdateRequest $request, Contact $contact): RedirectResponse
    {

        $contact->update($request->validated());

        $request->session()->flash('contact.id', $contact->id);

        return to_route('contacts.index');
    }

    public function destroy(Request $request, Contact $contact): RedirectResponse
    {
        $contact->delete();

        return to_route('contacts.index');
    }
}
