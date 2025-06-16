<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {
        Task::factory()->count(10)->create();

        // Tâche de test spécifique
        Task::create([
            'title' => 'Tâche de test',
            'description' => 'Ceci est une tâche pour tester le filtre.',
            'date' => now()->toDateString(),
            'time' => '14:30',
            'status' => false,
        ]);
    }
}