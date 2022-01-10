<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AccountController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\LessonController;




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

//account
Route::get('/account', [AccountController::class, 'getAll']);
Route::post('/account', [AccountController::class, 'insertAccount']);
Route::post('/account/login', [AccountController::class, 'loginAccount']);
Route::get('/account/test', [AccountController::class, 'auth']);
Route::put('/account/change-password', [AccountController::class, 'changePassword']);


//subject
Route::post('/subject', [SubjectController::class, 'insertSubject']);
Route::get('/subject', [SubjectController::class, 'getAll']);


//teacher
Route::get('/teacher', [TeacherController::class, 'getAll']);
Route::post('/teacher', [TeacherController::class, 'insertTeacher']);

//student
Route::get('/student',[StudentController::class, 'getAll']);

//lesson
Route::get('/lesson', [LessonController::class, 'getAll']);
Route::post('/lesson', [LessonController::class, 'insertLesson']);
Route::put('/lesson', [LessonController::class, 'editLesson']);
Route::delete('/lesson', [LessonController::class, 'deleteLesson']);


Route::get('/', function () {
    return view('welcome');
});
