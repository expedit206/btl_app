<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use App\Models\Category;
use Inertia\Inertia;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function index(Request $request)
    {
        $query = Movement::with('category')->latest();
        
        if ($request->has('date_from') && $request->date_from) {
            $query->where('date', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && $request->date_to) {
            $query->where('date', '<=', $request->date_to);
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        $movements = $query->get();
        // dd($movements);
        // dd($request->all());

        return Inertia::render('Movements/Index', [
            'movements' => $movements,
            'filters' => $request->only(['date_from', 'date_to', 'type']),
        ]);
    }
    public function create()
    {
        $categories = Category::all();
        return Inertia::render('Movements/Create', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:entry,exit',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|numeric|min:0',
            'value' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        Movement::create(array_merge($validated, ['user_id' => auth()->id()]));

        return redirect()->route('movements.index');
    }
    public function edit(Movement $movement)
    {
        $categories = Category::all();
        return Inertia::render('Movements/Edit', [
            'movement' => $movement,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, Movement $movement)
    {
        $validated = $request->validate([
            'type' => 'required|in:entry,exit',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|numeric|min:0',
            'value' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string',
        ]);

        $movement->update($validated);

        return redirect()->route('movements.index')->with('success', 'Mouvement mis à jour avec succès.');
    }

    public function destroy(Movement $movement)
    {
        $movement->delete();
        return redirect()->route('movements.index')->with('success', 'Mouvement supprimé avec succès.');
    }

}