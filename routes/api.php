<?php

use App\Http\Controllers\Api\CourseApiController;
use App\Http\Controllers\Api\StudentApiController;
use App\Http\Controllers\Api\LoginRegisterAPIController;
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

Route::resource('/apiCourses',CourseApiController::class);
Route::get('/apiCourses/get_lectures_by_course/{id}',[CourseApiController::class,'get_lectures_by_course']);
Route::post('/apiCourses/upload_lectures_to_course/{id}',[CourseApiController::class,'upload_lectures_to_course']);
Route::post('/apiCourses/destroy_lectures_from_course/{courseId}/{videoId}',[CourseApiController::class,'destroy_lectures_from_course']);
Route::resource('/apiStudents',StudentApiController::class);
Route::get('/apiStudents/get_students_course/{id}',[StudentApiController::class,'get_students_course']);
Route::post('/login',[LoginRegisterAPIController::class,'login']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
