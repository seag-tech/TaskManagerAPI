<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{

    public function getTasks()
    {
        $tasks = Task::all();

        return response()->json($tasks, 200);
    }

    public function showTask($id)
    {
        $task = Task::findOrFail($id);

        return response()->json($task, 200);
    }

    public function store(CreateTaskRequest $request)
    {
        Task::create([
            'user_id' => $request->user()->id,
            'title' => $request->validated('title'),
            'description' => $request->validated('description'),
            'due_date' => $request->validated('due_date'),
        ]);

        return response()->json(['message' => 'Task created successfully'], 200);
    }

    public function changeStatusTask(Request $request, Task $task)
    {
        Gate::authorize('changeStatusTask', $task);

        if ($task->due_date->lessThan(now())) {
            return response()->json(['message' => 'Task is already due'], 422);
        }

        $user = $request->user();



        $task->completed = !$task->completed;

        $task->save();

        return response()->json($task);
    }

    public function externalInfo($idTask)
    {
        $task = Task::findOrFail($idTask);

        $response = Http::get("https://jsonplaceholder.typicode.com/posts/$idTask");

        if ($response->successful()) {

            $externalInfo = $response->json();

            $data = [
                'task' => $task,
                'description' => $externalInfo
            ];

            return response()->json($data);
        } else {

            return response()->json(['error' => 'No se pudo obtener la información de la api externa'], $response->status());
        }
    }
}
