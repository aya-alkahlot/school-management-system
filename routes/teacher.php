<?php

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Quizzes\QuizzController;
use App\Http\Controllers\Students\AttendanceController;
use App\Http\Controllers\Students\OnlineClasseController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Teachers\dashboard\StudentController;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth:teacher']
    ],
    function () {

        //==============================dashboard============================
        Route::get('/teacher/dashboard', function () {

            // $ids = Teacher::findorFail(auth()->user()->id)->Sections()->pluck('section_id');
            // $data['count_sections']= $ids->count();
            // $data['count_students']= \App\Models\Student::whereIn('section_id',$ids)->count();

            //        $ids = DB::table('teacher_section')->where('teacher_id',auth()->user()->id)->pluck('section_id');
            //        $count_sections =  $ids->count();
            //        $count_students = DB::table('students')->whereIn('section_id',$ids)->count();
            return view('pages.Teachers.dashboard.dashboard');
        });


        Route::group(['prefix' => 'Teachers\dashboard'], function () {
            //==============================students============================
            Route::get('student', [StudentController::class, 'index'])->name('student.index');
            Route::get('sections', [StudentController::class, 'sections'])->name('sections');
            Route::post('attendance', [StudentController::class, 'attendance'])->name('attendance');
            Route::post('edit_attendance', [StudentController::class, 'editAttendance'])->name('attendance.edit');
        });
        // Route::group(['prefix' => 'Students'], function () {
        //     Route::get('/Students', [StudentController::class, 'index'])->name('Students.index');
        //     Route::get('/Students/create',  [StudentController::class, 'create'])->name('Students.create');
        //     Route::get('/Get_classrooms/{id}',  [StudentController::class, 'Get_classrooms']);
        //     Route::get('/Get_Sections/{id}',  [StudentController::class, 'Get_Sections']);
        //     Route::post('/Students/store', [StudentController::class, 'store'])->name('Students.store');
        //     Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('Students.edit');
        //     Route::get('/students/{id}', [StudentController::class, 'show'])->name('Students.show');
        //     Route::put('/Students/update', [StudentController::class, 'Update'])->name('Students.update');
        //     Route::delete('/Students/destroy', [StudentController::class, 'destroy'])->name('Students.destroy');
        //     Route::post('Upload_attachment', [StudentController::class, 'Upload_attachment'])->name('Upload_attachment');
        //     Route::post('Delete_attachment', [StudentController::class, 'Delete_attachment'])->name('Delete_attachment');
        // });
        // Route::get('/Download_attachment/{studentsname}/{filename}', [StudentController::class, 'Download_attachment'])->name('Download_attachment');
        //==============================End dashboard page of Students=============================


        Route::group(['prefix' => 'Quizzes'], function () {
            Route::get('/Quizzes', [QuizzController::class, 'index'])->name(name: 'Quizzes.index');
            Route::get('/Quizzes/create',  [QuizzController::class, 'create'])->name('Quizzes.create');
            Route::post('/Quizzes/store', [QuizzController::class, 'store'])->name('Quizzes.store');
            Route::get('/edit/{id}', [QuizzController::class, 'edit'])->name('Quizzes.edit');
            Route::put('/Quizzes/update', [QuizzController::class, 'update'])->name('Quizzes.update');
            Route::delete('/Quizzes/destroy', [QuizzController::class, 'destroy'])->name('Quizzes.destroy');
        });


        Route::group(['prefix' => 'online_classes'], function () {
            Route::get('/online_classes', [OnlineClasseController::class, 'index'])->name('online_classes.index');
            Route::get('/online_classes/create',  [OnlineClasseController::class, 'create'])->name('online_classes.create');
            Route::post('/online_classes/store', [OnlineClasseController::class, 'store'])->name('online_classes.store');
            Route::get('/edit/{id}', [OnlineClasseController::class, 'edit'])->name('online_classes.edit');
            Route::put('/online_classes/update', [OnlineClasseController::class, 'update'])->name('online_classes.update');
            Route::delete('/online_classes/destroy', [OnlineClasseController::class, 'destroy'])->name('online_classes.destroy');
        });
        Route::group(['prefix' => 'Attendance'], function () {
            Route::get('/Attendance', [AttendanceController::class, 'index'])->name('Attendance.index');
            Route::get('/Attendance/{id}', [AttendanceController::class, 'show'])->name('Attendance.show');
            Route::post('/Attendance/store', [AttendanceController::class, 'store'])->name('Attendance.store');
        });
    }
);
