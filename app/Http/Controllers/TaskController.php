<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use App\Models\Task;



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

    public function taskWithDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $user = $request->user();

        Task::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return response()->json(['message' => 'Task Created with due date'], 200);
    }

    public function taskWithOutDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }
        $user = $request->user();

        Task::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Task Created without due date'], 200);
    }

    public function completeTask(Request $request, $id)
    {

        $task = Task::findOrFail($id);

        $user = $request->user();

        if ($task->user_id !== $user->id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $task->completed = true;
        $task->save();

        return response()->json($task);
    }

    public function externalInfo(Request $request, $idTask)
    {
        $task = Task::findOrFail($idTask);

        $response = Http::get("https://jsonplaceholder.typicode.com/posts/$idTask");

        if ($response->successful()) {

            $externalInfo = $response->json();

            $data = [
                'task' => $task,
                'external_api_info' => $externalInfo
            ];

            return response()->json($data);
        } else {

            return response()->json(['error' => 'No se pudo obtener la información de la api externa'], $response->status());
        }
    }
}
