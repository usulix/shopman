<?php

namespace App\Http\Controllers;

use App\Http\Requests\RolesStoreRequest;
use App\Http\Requests\RolesUpdateRequest;
use App\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RolesController extends Controller
{
    public function index(Request $request): View
    {
        $roles = Role::all();

        return view('role.index', compact('roles'));
    }

    public function create(Request $request): View
    {
        return view('role.create');
    }

    public function store(RolesStoreRequest $request): RedirectResponse
    {
        $role = Role::create($request->validated());

        $request->session()->flash('role.id', $role->id);

        return redirect()->route('roles.index');
    }

    public function show(Request $request, Role $role): View
    {
        return view('role.show', compact('role'));
    }

    public function edit(Request $request, Role $role): View
    {
        return view('role.edit', compact('role'));
    }

    public function update(RolesUpdateRequest $request, Role $role): RedirectResponse
    {
        $role->update($request->validated());

        $request->session()->flash('role.id', $role->id);

        return redirect()->route('roles.index');
    }

    public function destroy(Request $request, Role $role): RedirectResponse
    {
        $role->delete();

        return redirect()->route('roles.index');
    }
}
