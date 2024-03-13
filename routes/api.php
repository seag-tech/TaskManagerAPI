<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\UserController;
use  App\Http\Controllers\TaskController;

Route::post('/login', [UserController::class, 'login']);

Route::post('/register', [UserController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('/get-tasks', [TaskController::class, 'getTasks']);

    Route::get('/show-task/{id}', [TaskController::class, 'showTask']);

    Route::post('/task-with-date', [TaskController::class, 'taskWithDate']);

    Route::post('/task-without-date', [TaskController::class, 'taskWithOutDate']);

    Route::put('/complete-task/{id}', [TaskController::class, 'completeTask']);

    Route::get('/external-info-task/{id}', [TaskController::class, 'externalInfo']);
});
