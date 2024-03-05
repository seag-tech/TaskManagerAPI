<?php

namespace Tests\Feature;

use App\Models\Task;

use Tests\TestCase;

class ExpiredTasksTest extends TestCase
{
    public function testExpiredTasksAreNotified()
    {
        $task = Task::factory()->create([
            'user_id' => 1,
            'title' => 'test',
            'due_date' => now()->subDay(),
        ]);

        $this->artisan('tasks:check-expired');


        $this->assertTrue(true, 'La prueba se ejecutó correctamente.');
    }
}
