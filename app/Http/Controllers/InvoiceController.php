<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Models\Invoice;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    public function index(Request $request): View
    {
        $invoices = Invoice::all();

        return view('invoice.index', compact('invoices'));
    }

    public function create(Request $request): View
    {
        return view('invoice.create');
    }

    public function store(InvoiceStoreRequest $request): RedirectResponse
    {
        $invoice = Invoice::create($request->validated());

        $request->session()->flash('invoice.id', $invoice->id);

        return redirect()->route('invoices.index');
    }

    public function show(Request $request, Invoice $invoice): View
    {
        return view('invoice.show', compact('invoice'));
    }

    public function edit(Request $request, Invoice $invoice): View
    {
        return view('invoice.edit', compact('invoice'));
    }

    public function update(InvoiceUpdateRequest $request, Invoice $invoice): RedirectResponse
    {
        $invoice->update($request->validated());

        $request->session()->flash('invoice.id', $invoice->id);

        return redirect()->route('invoices.index');
    }

    public function destroy(Request $request, Invoice $invoice): RedirectResponse
    {
        $invoice->delete();

        return redirect()->route('invoices.index');
    }
}
