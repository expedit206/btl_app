<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            // 'date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'date' => now()->toDateString(),
    
            'time' => $this->faker->time('H:i'),
            'status' => $this->faker->boolean(),
        ];
    }
}