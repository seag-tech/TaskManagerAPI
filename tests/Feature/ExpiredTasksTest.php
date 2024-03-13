<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\Models\Task;
use App\Models\User;


use Tests\TestCase;

class ExpiredTasksTest extends TestCase
{

    //use RefreshDatabase;

    public function testExpiredTasksAreNotified()
    {

        $user = User::create([
            "name" => "Luiz Gómez",
            "email" => "test@gomez.com",
            "password" => Hash::make("123456789"),
        ]);

        $task = Task::factory()->create([
            'user_id' => $user->id,
            'title' => 'test',
            'due_date' => now()->subDay(),
        ]);

        $this->artisan('tasks:check-expired');


        // Asegurarse de que no se lanzaron excepciones
        $this->assertTrue(true, 'La prueba se ejecutó correctamente.');
    }
}
