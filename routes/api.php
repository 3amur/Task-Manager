<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* start authentication routes */
Route::controller(AuthController::class)->group(function(){
    Route::post('register', 'register');
    Route::post('login', 'login');
});
/* end authentication routes */

/* start task manager routes */
Route::middleware('auth:sanctum')->group(function(){
    Route::apiResource('tasks', TaskController::class);
});
/* end task manager routes */
