<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersStoreRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsersController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function create(Request $request): View
    {
        return view('user.create');
    }

    public function store(UsersStoreRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        $request->session()->flash('user.id', $user->id);

        return redirect()->route('users.index');
    }

    public function show(Request $request, User $user): View
    {
        return view('user.show', compact('user'));
    }

    public function edit(Request $request, User $user): View
    {
        return view('user.edit', compact('user'));
    }

    public function update(UsersUpdateRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        $request->session()->flash('user.id', $user->id);

        return redirect()->route('users.index');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $user->delete();

        return redirect()->route('users.index');
    }
}
