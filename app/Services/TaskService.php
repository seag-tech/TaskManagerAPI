<?php

namespace App\Services;

use App\Library\Constants;
use App\Models\Task;
use GuzzleHttp\Client;

/**
 * Class TaskService
 * 
 * This class contains the business logic for the tasks
 * @package App\Services
 */
class TaskService
{
    public function __construct()
    {
    }

    /**
     * Get all tasks
     * 
     * @return array
     */
    public function getTasks(): array
    {
        return Task::select('id', 'title', 'description', 'due_date', 'completed')
            ->orderBy('created_at', 'desc')
            ->get()->toArray();
    }

    /**
     * Get a task by id
     * 
     * @param int $id
     * @return array|null
     */
    public function getTaskById(int $id): array|null
    {
        try {
            $task = Task::findOrFail($id);
        } catch (\Throwable $th) {
            return null;
        }

        return $task->toArray();
    }

    /**
     * Create a new task
     * 
     * @param array $data
     * @return array|null
     */
    public function createTask(array $data): array|null
    {


        try {
            $task = Task::create($data);
        } catch (\Throwable $th) {
            return null;
        }

        return $task->toArray();
    }


    /**
     * Set the status of a task
     * 
     * @param int $id
     * @param bool $status
     * 
     * @return array|null
     */
    public function setStatus(int $id, bool $status): array|null
    {
        try {
            $task               = Task::findOrFail($id);
            $task->completed    = $status;
        } catch (\Throwable $th) {
            return null;
        }
        return $task->toArray();
    }

    /**
     * 
     */
    public function externalTodos()
    {
        $request    = (new Client())->request('GET', Constants::JSON_PLACEHOLDER_API.'/todos');
        $data       = $request->getBody()->getContents();
        $status     = $request->getStatusCode();
        return [
            'code'    => $status,
            'data'      => json_decode($data, true)
        ];
    }
}
