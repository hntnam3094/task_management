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


Route::get('/user_list', [\App\Http\Controllers\AuthController::class, 'userList']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/re-verify', [\App\Http\Controllers\AuthController::class, 'reVerify']);
Route::post('/forget-password', [\App\Http\Controllers\AuthController::class, 'forgetPassword']);
Route::post('/change-password', [\App\Http\Controllers\AuthController::class, 'changePassword']);
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/check-token', function () {
    return response()->json(['message' => 'Token is valid', 'code' => 200]);
})->middleware('auth:sanctum');
Route::post('/verifyToken', [\App\Http\Controllers\AuthController::class, 'verifyToken']);

Route::prefix('/public')->group(function () {
    Route::get('/blog', [\App\Http\Controllers\BlogController::class, 'publicBlog']);
    Route::get('/latest-blog', [\App\Http\Controllers\BlogController::class, 'latestBlog']);
    Route::get('/blog/{slug}', [\App\Http\Controllers\BlogController::class, 'publicBlogDetail']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tasks/done/{id}', [\App\Http\Controllers\TaskController::class, 'complete']);
    Route::post('/task_child/done/{id}', [\App\Http\Controllers\TaskChildController::class, 'doneStatus']);
    Route::resource('tasks', \App\Http\Controllers\TaskController::class);
    Route::resource('task_child', \App\Http\Controllers\TaskChildController::class);
    Route::resource('task_note', \App\Http\Controllers\TaskNoteController::class);
    Route::resource('blog', \App\Http\Controllers\BlogController::class);

});


Route::post('/test_sendmail', [\App\Http\Controllers\AuthController::class, 'sendEmailTest']);


