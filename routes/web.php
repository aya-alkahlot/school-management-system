<?php
namespace App\Http\Controllers\Grades;
// use App\Http\Controllers\Grades\GradeController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

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

Route::group(['middleware'=>['guest']],function(){
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
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ,'auth']
], function()
    
{
	/** ADD ALL LOCALIZED ROUTES INSIDE THIS GROUP **/
	// Route::get('/', function () {
    //     return view('dashboard');
    // });
    Route::get('/dashboard', action: [HomeController::class, 'index'])->name('dashboard');


   //==============================dashboard page of Grades============================
Route::group(['prefix' => 'Grades'], function () {
    Route::get('/Grades', [GradeController::class, 'index'])->name('Grades.index');
    Route::post('/grades', [GradeController::class, 'store'])->name('Grades.store');
    Route::patch('/update/{id}', [GradeController::class, 'update'])->name('Grades.update');
    Route::delete('/destroy/{id}', [GradeController::class, 'destroy'])->name('Grades.destroy');
});





});

