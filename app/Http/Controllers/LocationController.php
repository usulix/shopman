<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationStoreRequest;
use App\Http\Requests\LocationUpdateRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(Request $request): View
    {
        $locations = Location::all();

        return view('location.index', compact('locations'));
    }

    public function create(Request $request): View
    {
        return view('location.create');
    }

    public function store(LocationStoreRequest $request): RedirectResponse
    {
        $location = Location::create($request->validated());

        $request->session()->flash('location.id', $location->id);

        return redirect()->route('locations.index');
    }

    public function show(Request $request, Location $location): View
    {
        return view('location.show', compact('location'));
    }

    public function edit(Request $request, Location $location): View
    {
        return view('location.edit', compact('location'));
    }

    public function update(LocationUpdateRequest $request, Location $location): RedirectResponse
    {
        $location->update($request->validated());

        $request->session()->flash('location.id', $location->id);

        return redirect()->route('locations.index');
    }

    public function destroy(Request $request, Location $location): RedirectResponse
    {
        $location->delete();

        return redirect()->route('locations.index');
    }
}
