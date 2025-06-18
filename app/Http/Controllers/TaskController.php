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
        $tasks = Task::all(); // Récupérer toutes les tâches

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
            'time' => 'nullable|date_format:H:i',
        ]);

        Task::create($validated);
        return redirect()->route('tasks.index')->with('success', 'Tâche créée.');
    }

    public function edit(Task $task)
    {
        return Inertia::render('Tasks/Edit', ['task' => $task]);
    }

    public function update(Request $request, Task $task)
    {
        // Vérifier si seule la modification du statut est demandée
        if ($request->has('status') && count($request->all()) === 1) {
            $validated = $request->validate([
                'status' => 'required|boolean',
            ]);

            $task->update(['status' => $validated['status']]);
        } else {
            // Modification complète de la tâche
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date' => 'required|date',
                'time' => 'nullable|date_format:H:i',
                'status' => 'sometimes|boolean',
            ]);

            $task->update($validated);
        }
        // dd($task);  

        return redirect()->route('tasks.index')->with('success', 'Tâche mise à jour.');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Tâche supprimée.');
    }
}