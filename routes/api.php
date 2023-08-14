<?php

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

Route::post('/auth', 'App\Http\Controllers\UserController@auth')->name('auth');

Route::middleware('auth:sanctum')->group( function () {
    Route::get('/tasks', 'App\Http\Controllers\TaskController@index');
    Route::post('/tasks', 'App\Http\Controllers\TaskController@store');
    Route::get('/tasks/{id}', 'App\Http\Controllers\TaskController@show');
    Route::put('/tasks/{id}', 'App\Http\Controllers\TaskController@update')->middleware('CheckTaskOwner');
    Route::delete('/tasks/{id}', 'App\Http\Controllers\TaskController@destroy')->middleware('CheckTaskOwner');
});
