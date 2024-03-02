<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('tasks')->group(function () {
    Route::get('/',                     [TaskController::class, 'getTasks']);
    Route::get('/{id}',                 [TaskController::class, 'getTaskById']);
    Route::post('/create',              [TaskController::class, 'createTask']);
    Route::put('/set-complete/{id}',    [TaskController::class, 'setCompletedTask']);
});

Route::get('/external-todos',       [TaskController::class, 'externalTodos']);
