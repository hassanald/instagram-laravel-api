<?php

use Illuminate\Http\Request;
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


//Private Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('accounts/logout' , [\App\Http\Controllers\AuthController::class , 'logout']);
    //Post
    Route::post('/post/store' , [\App\Http\Controllers\PostController::class , 'store']);
    Route::post('/post/{id}/update' , [\App\Http\Controllers\PostController::class , 'update']);
    Route::delete('/post/{id}/delete' , [\App\Http\Controllers\PostController::class , 'destroy']);

});


//Public Routes
Route::post('/accounts/register' , [\App\Http\Controllers\AuthController::class , 'register']);
Route::post('accounts/login' , [\App\Http\Controllers\AuthController::class , 'login']);
Route::get('/posts' , [\App\Http\Controllers\PostController::class , 'index']);

