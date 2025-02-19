<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Quizzes\QuizzController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


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
    // Route::group(['prefix' => 'Quizzes'], function () {
    //     Route::get('/Quizzes', [QuizzController::class, 'index'])->name('Quizzes.index');
    //     Route::get('/Quizzes/create',  [QuizzController::class, 'create'])->name('Quizzes.create');
    //     Route::post('/Quizzes/store', [QuizzController::class, 'store'])->name('Quizzes.store');
    //     Route::get('/edit/{id}', [QuizzController::class, 'edit'])->name('Quizzes.edit');
    //     Route::put('/Quizzes/update', [QuizzController::class, 'update'])->name('Quizzes.update');
    //     Route::delete('/Quizzes/destroy', [QuizzController::class, 'destroy'])->name('Quizzes.destroy');
    // });

    // Route::group(['prefix' => 'settings'], function () {
    //     Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    //     Route::put('/settings/update', [SettingController::class, 'update'])->name('settings.update');
    // });

});

