<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ToDoListController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

//protected routes
Route::group(
    ['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('todolist', ToDoListController::class)->only('index', 'store', 'update', 'destroy');
    Route::put('todolist/{todolist}/complete', [ToDoListController::class, 'complete']);

}
);
