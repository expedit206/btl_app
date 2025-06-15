<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Tasks (index et create)
Route::get('/tasks', [TaskController::class, 'index'])->middleware(['auth'])->name('tasks.index');
Route::get('/tasks/create', [TaskController::class, 'create'])->middleware(['auth'])->name('tasks.create');

// Categories (index et create)
Route::get('/categories', [CategoryController::class, 'index'])->middleware(['auth'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->middleware(['auth'])->name('categories.create');


require __DIR__.'/settings.php';
require __DIR__.'/auth.php';