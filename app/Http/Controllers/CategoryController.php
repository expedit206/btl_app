<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()->categories()->get();
        return Inertia::render('Categories/Index', ['categories' => $categories]);
    }

    public function create()
    {
        return Inertia::render('Categories/Create');
    }

    public function store(CategoryRequest $request)
    {
        auth()->user()->categories()->create($request->validated());
        return redirect()->route('categories.index')->with('success', 'Category created.');
    }
}