<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generar 10 tareas
        for ($i = 0; $i < 10; $i++) {
            Task::create([
                'name' => 'task ' . $i, // Genera un nombre aleatorio
                'description' => 'descripcion ' . $i, // Genera una descripción aleatoria
                'completed' => false, // Genera un valor booleano aleatorio
                'user_id' => 2, // Genera un valor entero aleatorio
                'priority_id' => 2, // Genera un valor entero aleatorio
            ]);
        }
    }
}
