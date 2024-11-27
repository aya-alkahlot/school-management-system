<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\Classrooms\ClassroomController;
use App\Http\Controllers\Sections\SectionController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// 

Auth::routes();

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        // return view('auth.login');
        return view('dashboard');
        // return view('empty');

    });
});
Route::get('/', function () {
    return view('auth.login');
});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
], function () {
    /** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
    // Route::get('/', function () {
    //     return view('dashboard');
    // });
    Route::get('/dashboard', action: [HomeController::class, 'index'])->name('dashboard');


    //==============================Start dashboard page of Grades============================
    Route::group(['prefix' => 'Grades'], function () {
        Route::get('/Grades', [GradeController::class, 'index'])->name('Grades.index');
        Route::post('/grades', [GradeController::class, 'store'])->name('Grades.store');
        Route::patch('/update/{id}', [GradeController::class, 'update'])->name('Grades.update');
        Route::delete('/destroy/{id}', [GradeController::class, 'destroy'])->name('Grades.destroy');
    });
    //==============================End dashboard page of Grades============================

    //==============================Start dashboard page of Classes_Room============================
    Route::group(['prefix' => 'Classrooms'], function () {
        Route::get('/Classrooms', [ClassroomController::class, 'index'])->name('Classrooms.index');
        Route::post('/Classrooms/store', [ClassroomController::class, 'store'])->name('Classrooms.store');
        Route::patch('/Classrooms/update', [ClassroomController::class, 'update'])->name('Classrooms.update');
        Route::delete('/Classrooms/destroy', [ClassroomController::class, 'destroy'])->name('Classrooms.destroy');
        Route::delete('/Classrooms/delete_all', [ClassroomController::class, 'delete_all'])->name('Classrooms.delete_all');
        Route::post('/Classrooms', [ClassroomController::class, 'Filter_Classes'])->name('Filter_Classes');
    });
    //==============================End dashboard page of Classes_Room============================

    //==============================Start dashboard page of Sections============================
    Route::group(['prefix' => 'Sections'], function () {
        Route::get('/Sections', [SectionController::class, 'index'])->name('Sections.index');
        Route::get('/classes/{id}',  [SectionController::class, 'getClassrooms'])->name('classes');
        Route::post('/Sections/store', [SectionController::class, 'store'])->name('Sections.store');
        Route::patch('/Sections/update', [SectionController::class, 'update'])->name('Sections.update');
        Route::delete('/Sections/destroy', [SectionController::class, 'destroy'])->name('Sections.destroy');
        Route::delete('/Sections/delete_all', [SectionController::class, 'delete_all'])->name('Sections.delete_all');
    });
    //==============================End dashboard page of Sections============================


});
