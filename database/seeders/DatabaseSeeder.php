<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\TaskSeeder;
use Database\Seeders\ScheduleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'dom' ,
            'password' => bcrypt('dom'),
            'email' => 'aaa@aaa',
        ]);
        $this->call([
            ScheduleSeeder::class,
            TaskSeeder::class,
        ]);
    }
}