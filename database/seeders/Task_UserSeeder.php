<?php

namespace Database\Seeders;


use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;


class Task_UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            "name" => "Luiz Gómez",
            "email" => "test@gomez.com",
            "password" => Hash::make("123456789"),
        ]);

        $task = Task::create([
            'title' => 'Tarea 1',
            'description' => 'Descripción de la tarea 1',
            'completed' => false,
            'due_date' => '2024-03-31',
            'user_id' => $user->id,
        ]);

        $task = Task::create([
            'title' => 'Tarea 2',
            'description' => 'Descripción de la tarea 2',
            'completed' => false,
            'due_date' => '2024-06-11',
            'user_id' => $user->id,
        ]);
    }
}
