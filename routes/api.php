<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/courses', [CourseController::class, 'index']);
Route::get('/courses/{id}', [CourseController::class, 'getById']);
Route::post('/courses/create', [CourseController::class, 'create']);
Route::put('/courses/update/{course}', [CourseController::class, 'update']);
Route::put('/courses/delete/{course}', [CourseController::class, 'delete']);

Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'getById']);
Route::post('/students/create', [StudentController::class, 'create']);
Route::put('/students/update/{student}', [StudentController::class, 'update']);
Route::put('/students/delete/{student}', [StudentController::class, 'delete']);