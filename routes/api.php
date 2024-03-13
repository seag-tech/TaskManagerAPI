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

    Route::post('/task/create', [TaskController::class, 'store']);


    Route::put('/task/{task}/change-status', [TaskController::class, 'changeStatusTask']);

    Route::get('/external-info-task/{id}', [TaskController::class, 'externalInfo']);
});
