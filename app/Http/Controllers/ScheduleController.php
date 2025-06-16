<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleRequest;
use App\Models\Schedule;
use Inertia\Inertia;

class ScheduleController extends Controller
{
    public function index()
    {
        $selectedDate = request()->input('selectedDate');
        $schedules = $selectedDate
            ? Schedule::where('date', $selectedDate)->get()
            : Schedule::all();
        return Inertia::render('Schedules/Index', ['schedules' => $schedules, 'selectedDate' => $selectedDate]);
    }

    public function create()
    {
        return Inertia::render('Schedules/Create');
    }

    public function store(ScheduleRequest $request)
    {
        Schedule::create($request->validated());
        return redirect()->route('schedules.index')->with('success', 'Schedule created.');
    }

    public function update(ScheduleRequest $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->update($request->validate(['status' => 'boolean']));
        return redirect()->back();
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return redirect()->back();
    }
}