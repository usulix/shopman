<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStoreRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = Task::all();

        return Inertia::render('Tasks/Index', compact('tasks'));
    }

    public function create(Request $request): View
    {
        return view('task.create');
    }

    public function store(TaskStoreRequest $request): RedirectResponse
    {
        $task = Task::create($request->validated());

        $request->session()->flash('task.id', $task->id);

        return redirect()->route('tasks.index');
    }

    public function show(Request $request, Task $task): View
    {
        return view('task.show', compact('task'));
    }

    public function edit(Request $request, Task $task): View
    {
        return view('task.edit', compact('task'));
    }

    public function update(TaskUpdateRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());

        $request->session()->flash('task.id', $task->id);

        return redirect()->route('tasks.index');
    }

    public function destroy(Request $request, Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }
}
