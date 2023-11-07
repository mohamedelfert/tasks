<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for ($i = 1; $i <= 15; $i++) {
            Task::create([
                'title' => $faker->unique()->words($nb = 3, $asText = true),
                'description' => $faker->paragraph(),
                'date' => $faker->date('Y_m_d'),
                'finished' => 0,
            ]);
        }
    }
}
