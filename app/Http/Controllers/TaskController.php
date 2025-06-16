<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->input('dateFilter', now()->toDateString());
        $tasks = Task::whereDate('date', $selectedDate)->get();

        return Inertia::render('Tasks/Index', [
            'tasks' => $tasks,
            'selectedDate' => $selectedDate,
        ]);
    }

    public function create()
    {
        return Inertia::render('Tasks/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        Task::create($validated);
        return redirect()->route('tasks.index')->with('success', 'Tâche créée.');
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|boolean',
        ]);

        $task->update($validated);
        return redirect()->route('tasks.index')->with('success', 'Statut mis à jour.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée.');
    }
}