<?php

namespace App\Http\Controllers;

use App\Http\Requests\UnitStoreRequest;
use App\Http\Requests\UnitUpdateRequest;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UnitController extends Controller
{
    public function index(Request $request): View
    {
        $units = Unit::all();

        return view('unit.index', compact('units'));
    }

    public function create(Request $request): View
    {
        return view('unit.create');
    }

    public function store(UnitStoreRequest $request): RedirectResponse
    {
        $unit = Unit::create($request->validated());

        $request->session()->flash('unit.id', $unit->id);

        return redirect()->route('units.index');
    }

    public function show(Request $request, Unit $unit): View
    {
        return view('unit.show', compact('unit'));
    }

    public function edit(Request $request, Unit $unit): View
    {
        return view('unit.edit', compact('unit'));
    }

    public function update(UnitUpdateRequest $request, Unit $unit): RedirectResponse
    {
        $unit->update($request->validated());

        $request->session()->flash('unit.id', $unit->id);

        return redirect()->route('units.index');
    }

    public function destroy(Request $request, Unit $unit): RedirectResponse
    {
        $unit->delete();

        return redirect()->route('units.index');
    }
}
