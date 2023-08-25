<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AttendanceController;

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

Route::get('/teachers', [TeacherController::class, 'index']);
Route::get('/teachers/{id}', [TeacherController::class, 'getById']);
Route::post('/teachers/create', [TeacherController::class, 'create']);
Route::put('/teachers/update/{student}', [TeacherController::class, 'update']);
Route::put('/teachers/delete/{student}', [TeacherController::class, 'delete']);

Route::get('/attendance', [AttendanceController::class, 'index']);
Route::get('/attendance/{id}', [AttendanceController::class, 'getByDate']);
Route::post('/attendance/create', [AttendanceController::class, 'create']);
/* Route::put('/attendance/update/{student}', [AttendanceController::class, 'update']);
Route::put('/attendance/delete/{student}', [AttendanceController::class, 'delete']); */

