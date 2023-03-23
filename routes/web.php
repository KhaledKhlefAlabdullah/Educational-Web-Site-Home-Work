<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\StaticController;
use \App\Http\Controllers\CourseController;
use \App\Http\Controllers\VideoController;
use \App\Http\Controllers\AdminController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => '/'], function()
{
    Route::get('/',[StaticController::class,'index'])->name("blade.home");
    Route::get('/about',[StaticController::class,'about'])->name("blade.about");
    Route::get('/contact',[StaticController::class,'contact'])->name("blade.contact");

    Route::get('/trainers',[StaticController::class,'trainers'])->name("blade.trainers");
    Route::get('/events',[StaticController::class,'events'])->name("blade.events");
    Route::get('/pricing',[StaticController::class,'pricing'])->name("blade.pricing");


    Route::resource('courses',CourseController::class);

    Route::get('/courses',[CourseController::class,'index'])->name("courses.index");
    Route::get('/courses/courses_by_department/{id}',[CourseController::class,"index_by_department"])->name("courses.index_by_department");
    Route::get('/courses/create',[CourseController::class,'create'])->name('courses.create')->middleware(['auth', 'teacher']);
    Route::delete('/courses/{course}', [CourseController::class,'destroy'])->name('courses.destroy')->middleware(['auth', 'teacher']);
    Route::get('/courses/edit/{course}', [CourseController::class,'edit'])->name('courses.edit')->middleware(['auth', 'teacher']);
    Route::patch('/courses/update/{id}', [CourseController::class,'update'])->name('courses.update')->middleware(['auth', 'teacher']);
    Route::get('/courses/details/{course}', [CourseController::class,'details'])->name('courses.details')->middleware(['auth', 'teacher']);
    Route::post('/videos/store/{id}',[VideoController::class,'store'])->name('video.store')->middleware(['auth','teacher']);
    Route::delete('/videos/destroy/{vid}/{cid}',[VideoController::class,'destroy'])->name('video.destroy')->middleware(['auth','teacher']);
    Route::middleware(['auth','admin'])->group(function (){
        Route::get('/admin/create_users',[AdminController::class,'create'])->name('admin.create_users');
        Route::get('/admin/detail_user/{id}',[AdminController::class,'details'])->name('admin.detail_user');
        Route::get('/admin/create_course/{id}',[AdminController::class,'create_course'])->name('admin.create_course');
        Route::post('/admin/store_course/{id}',[AdminController::class,'store_course'])->name('admin.store_course');
        Route::post('/admin/destroy_user/{id}',[AdminController::class,'destroy_user'])->name('admin.destroy_user');

        Route::resource('/admin',AdminController::class);
    });

    /*Route::get('/profile', function () {
        return view('profile');
    })->middleware(['auth', 'verified'])->name('profile');
    */
    Route::middleware('auth')->group(function () {
        Route::get('/profile',[ProfileController::class,'index'])->name('profile.index');
        Route::get('/profile/edite', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile/edite', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile/edite', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/courses/addToStudent/{id}',[CourseController::class,'addToStudent'])->name('courses.addToStudent');
        Route::delete('/courses/GoOutFromCourse/{id}',[CourseController::class,'GoOutFromCourse'])->name('courses.GoOutFromCourse');
    });
    require __DIR__ . '/auth.php';
});

