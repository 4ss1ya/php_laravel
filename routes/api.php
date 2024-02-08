<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserCourseController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ReviewController;

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

//user
Route::post('/createUser', [UserController::class, 'create']);
Route::get('/showUser/{id}', [UserController::class, 'show']);
Route::get('/userList', [UserController::class, 'userList']);
Route::put('/updateUser/{id}', [UserController::class, 'update']);
Route::delete('/deleteUser/{id}', [UserController::class, 'delete']);

//user courses
Route::post('/createUserCourse', [UserCourseController::class, 'create']);
Route::get('/showUserCourse/{id}', [UserCourseController::class, 'show']);
Route::get('/UserCourseList', [UserCourseController::class, 'List']);
Route::put('/updateUserCourse/{id}', [UserCourseController::class, 'update']);
Route::delete('/deleteUserCourse/{id}', [UserCourseController::class, 'delete']); 

//course
Route::post('/createCourse', [CourseController::class, 'create']);
Route::get('/showCourse/{id}', [CourseController::class, 'item']);
Route::get('/courseList', [CourseController::class, 'CourseList']);
Route::put('/updateCourse/{id}', [CourseController::class, 'update']);
Route::delete('/deleteCourse/{id}', [CourseController::class, 'delete']);

//quiz
Route::post('/createQuiz', [QuizController::class, 'create']);
Route::get('/showQuiz/{id}', [QuizController::class, 'show']);
Route::get('/quizList', [QuizController::class, 'quizList']);
Route::put('/updateQuiz/{id}', [QuizController::class, 'update']);
Route::delete('/deleteQuiz/{id}', [QuizController::class, 'delete']);

//review
Route::post('/createReview', [ReviewController::class, 'create']);
Route::get('/showReview/{id}', [ReviewController::class, 'show']);
Route::get('/reviewList', [ReviewController::class, 'reviewList']);
Route::put('/updateReview/{id}', [ReviewController::class, 'update']);
Route::delete('/deleteReview/{id}', [ReviewController::class, 'delete']);
