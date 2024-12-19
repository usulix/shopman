<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Models\Customer;
use App\Models\Unit;
use Auth;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $userAccounts = DB::table("account_user as au")
            ->join('accounts as a','au.account_id', '=', 'a.id')
            ->where('user_id', Auth::id())
            ->pluck('account_id')->toArray();

        $customers = DB::table('customers')->whereIn('account_id', $userAccounts)
            ->paginate(15);

        return Inertia::render('Customer/Index', compact('customers'));
    }

    public function create(Request $request): View
    {
        return view('customer.create');
    }

    public function store(CustomerStoreRequest $request): RedirectResponse
    {
        $customer = DB::table('customer')->create($request->validated());

        $request->session()->flash('customer.id', $customer->id);

        return redirect()->route('customers.index');
    }

    public function show(Request $request, Customer $customer): View
    {
        return view('customer.show', compact('customer'));
    }

    public function edit(Request $request, Customer $customer)
    {
        $units = DB::table('units')->where('customer_id', $customer->id)->get();

        return Inertia::render('Customer/Edit', compact('customer', 'units'));
    }

    public function update(CustomerUpdateRequest $request, Customer $customer): RedirectResponse
    {

        $customer->update($request->validated());

        $request->session()->flash('customer.id', $customer->id);

        return to_route('customers.index');
    }

    public function destroy(Request $request, Customer $customer): RedirectResponse
    {
        $customer->delete();

        return redirect()->route('customers.index');
    }
}
