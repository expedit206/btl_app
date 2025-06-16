<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run()
    {
        Schedule::factory()->count(20)->create(); // 20 événements aléatoires
    }
}