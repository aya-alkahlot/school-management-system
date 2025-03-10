<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\Api\Quizz\ApiQuizzController;
use App\Http\Controllers\backend\Api\Grades\ApiGradeController;
use App\Http\Controllers\backend\Api\Sections\ApiSectionController;
use App\Http\Controllers\backend\Api\Subjects\ApiSubjectController;
use App\Http\Controllers\backend\Api\Teachers\ApiTeacherController;
use App\Http\Controllers\backend\Api\Question\ApiQuestionController;
use App\Http\Controllers\backend\Api\Classroms\ApiClassroomController;
use App\Http\Controllers\backend\Api\Students\ApiAttendanceController;



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


// ***************************************Start Routes for Classroom API ************************************
Route::apiResource('classrooms', ApiClassroomController::class);
Route::delete('classrooms/{id}', [ApiClassroomController::class, 'destroy']);
Route::delete('classrooms/delete-all', [ApiClassroomController::class, 'delete_all']);
Route::get('/classrooms/filter', [ApiClassroomController::class, 'Filter_Classes']);
// ***************************************End Routes for Classroom API **************************************


// ***************************************Start Routes for Grades API ************************************
Route::apiResource('/grades', ApiGradeController::class);
Route::delete('/grades/{id}', [ApiGradeController::class, 'destroy']);
// ***************************************End Routes for Grades API **************************************


// ***************************************Start Routes for Question API ************************************
Route::apiResource('/questions', ApiQuestionController::class);
Route::delete('/questions/{id}', [ApiQuestionController::class, 'destroy']);
// ***************************************End Routes for Question API **************************************

// ***************************************Start Routes for Quizz API ************************************
Route::apiResource('/quizzes', ApiQuizzController::class);
Route::delete('/quizzes/{id}', [ApiQuizzController::class, 'destroy']);
// ***************************************End Routes for Quizz API **************************************

// ***************************************Start Routes for sections API ************************************
Route::apiResource('/sections', ApiSectionController::class);
Route::get('/sections/classrooms/{id}', [ApiSectionController::class, 'getClassrooms']);
Route::delete('/sections/{id}', [ApiSectionController::class, 'destroy']);
// ***************************************End Routes for sections API **************************************

// ***************************************Start Routes for subjects API ************************************
Route::apiResource('/subjects', ApiSubjectController::class);
Route::delete('/subjects/{id}', [ApiSubjectController::class, 'destroy']);
// ***************************************End Routes for subjects API **************************************


// ***************************************Start Routes for Students API ************************************
Route::apiResource('/attendance', ApiAttendanceController::class);
// ***************************************End Routes for Students API **************************************



// ***************************************Start Routes for Students API ************************************
Route::apiResource('/teachers', ApiTeacherController::class);
Route::delete('/teachers/delete_all', [ApiTeacherController::class, 'delete_all']);
// ***************************************End Routes for Students API **************************************
