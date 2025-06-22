<?php

namespace App\Http\Controllers;

use App\Models\Movement;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $totalEntries = Movement::totalEntries();
        $totalExits = Movement::totalExits();
        $net = Movement::net();
        $movements = Movement::with('category')->latest()->get();
        return Inertia::render('Dashboard', [
            'totalEntries' => $totalEntries,
            'totalExits' => $totalExits,
            'net' => $net,
            'movements' => $movements,
        ]);
    }
}