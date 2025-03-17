<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\backend\Students\dashboard\ExamsController;
use App\Http\Controllers\backend\Students\dashboard\RegistrationController;


/*
|--------------------------------------------------------------------------
| student Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//==============================Translate all pages============================
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:student']
    ], function () {

    //==============================dashboard============================
    Route::get('/student/dashboard', function () {
        return view('pages.Students.dashboard');

    });
    Route::group(['namespace' => 'App\Http\Controllers\backend\Students\dashboard'], function () {
        Route::resource('student_exams', ExamsController::class);
    });
    Route::group(['prefix' => 'Students\dashboard'], function () {
        Route::get('student_exams', [ExamsController::class, 'index'])->name('student_exams.index');
        Route::get('/student_exams/show/{id}', [ExamsController::class, 'show'])->name('student_exams.show');

    });

        //============================== عرض المواد الدراسية ============================
        Route::get('/student/dashboard/subjects', [RegistrationController::class, 'index'])->name('student.subjects.index');
        Route::get('/auto-register-student/{id}', [RegistrationController::class, 'autoRegisterStudent']);
        
        // Route::group(['prefix' => 'profile'], function () {
        //     Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        //     Route::post('profile-student/{id}', [ProfileController::class, 'update'])->name('profile-student.update');
        // });

});

