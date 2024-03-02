<?php

namespace App\Http\Controllers;

use App\Library\HttpCodes;
use App\Services\ApiService;
use Illuminate\Http\Request;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{

    private TaskService $taskService;
    private ApiService  $apiService;

    public function __construct()
    {
        $this->taskService  = new TaskService();
        $this->apiService   = new ApiService();
    }

    /**
     * Get all tasks
     * 
     * @return JsonResponse
     */
    public function getTasks(): JsonResponse
    {
        return response()->json($this->taskService->getTasks());
    }

    /**
     * Get a task by id
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function getTaskById(int $id): JsonResponse
    {

        $task = $this->taskService->getTaskById($id);

        return response()->json($task, $task ? HttpCodes::OK : HttpCodes::NOT_FOUND);
    }


    /**
     * Create a new task with due date or not
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function createTask(Request $request): JsonResponse
    {
        try {
            Validator::make($request->all(), [
                'title'         => 'required|string|max:255',
                'description'   => 'nullable|string',
                'due_date'      => 'nullable|date|date_format:Y-m-d',
            ], [
                'title.required'        => 'The title field is required',
                'title.string'          => 'The title field must be a string',
                'title.max'             => 'The title field must be less than 255 characters',
                'description.string'    => 'The description field must be a string',
                'due_date.date'         => 'The due date field must be a date',
                'due_date.date_format'  => 'The due date field must be in the format Y-m-d'
            ]
            )->validate();

            $task = $this->taskService->createTask($request->all());

            return response()->json($task, $task ? HttpCodes::CREATED : HttpCodes::INTERNAL_SERVER_ERROR);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], HttpCodes::BAD_REQUEST);
        }
    }


    /**
     * Set the status of a task
     * 
     * @param int $id
     * @return JsonResponse
     */
    public function setCompletedTask(int $id): JsonResponse
    {
        $task = $this->taskService->setStatus($id, true);
        return response()->json($task, $task ? HttpCodes::OK : HttpCodes::NOT_FOUND);
    }


    /**
     * Get all todos from the external API
     * 
     * @return JsonResponse
     */
    public function externalTodos(): JsonResponse
    {
        $data = $this->apiService->getExternalTodos();
        return response()->json($data['data'], $data['code']);
    }
}
