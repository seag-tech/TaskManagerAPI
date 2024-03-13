<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    public function test_cannot_create_task_without_description(): void
    {
        $body = [
            'title' => 'Test Task',
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/task/create', $body);

        $response->assertStatus(422)->assertJsonValidationErrors('description');
    }

    public function test_cannot_create_task_without_title(): void
    {
        $body = [
            'descritpion' => 'Test Task',
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/task/create', $body);

        $response->assertStatus(422)->assertJsonValidationErrors('title');
    }

    public function test_cannot_create_task_with_date_format_invalid(): void
    {
        $body = [
            'title' => 'Test Task',
            'description' => 'sddsffd',
            'due_date' => '12/02/12',
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/task/create', $body);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors('due_date');
    }

    public function test_can_create_task_without_date(): void
    {
        $body = [
            'title' => 'Test Task',
            'description' => 'This is a test task',
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/task/create', $body)->dump();

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', $body);
    }


    public function test_can_create_task_with_date(): void
    {
        $body = [
            'title' => 'Test Task',
            'description' => 'sddsffd',
            'due_date' => '2021-12-12',
        ];

        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/task/create', $body);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', $body);
    }

    public function test_cannot_complete_due_task(): void
    {

        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create();

        $body = [
            'completed' => true
        ];

        $response = $this->actingAs($user)->putJson("api/task/$task->id/change-status", $body);

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'Task is already due']);
    }


    public function test_another_user_cannot_complete_task(): void
    {
        $user = User::factory()->create();
        $status = fake()->boolean;

        $task = Task::factory()->for($user)->create(['due_date' => now()->addDays(2), 'completed' => $status]);

        $body = [];

        $newUser = User::factory()->create();
        $response = $this->actingAs($newUser)->putJson("api/task/$task->id/change-status", $body);

        $response->assertStatus(403);
    }
    public function test_can_complete_task(): void
    {
        $user = User::factory()->create();
        $status = fake()->boolean;

        $task = Task::factory()->for($user)->create(['due_date' => now()->addDays(2), 'completed' => $status]);

        $body = [];


        $response = $this->actingAs($user)->putJson("api/task/$task->id/change-status", $body);

        $response->assertStatus(200);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'completed' => !$status]);
    }
}
