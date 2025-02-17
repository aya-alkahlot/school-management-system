<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Teachers\dashboard\QuizzController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Teachers\dashboard\StudentController;
use App\Http\Controllers\Teachers\dashboard\QuestionController;

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
            Route::get('attendance_report', [StudentController::class, 'attendanceReport'])->name('attendance.report');
            Route::post('attendance_report', [StudentController::class, 'attendanceSearch'])->name('attendance.search');


            Route::get('/quizzes', [QuizzController::class, 'index'])->name('quizzes.index');
            Route::get('/quizzes/create',  [QuizzController::class, 'create'])->name('quizzes.create');
            Route::post('/quizzes/store', [QuizzController::class, 'store'])->name('quizzes.store');
            Route::get('/quizzes/edit/{id}',  [QuizzController::class, 'edit'])->name('quizzes.edit');
            Route::put('/quizzes/update', [QuizzController::class, 'update'])->name('quizzes.update');
            Route::get('/quizzes/show/{id}', [QuizzController::class, 'show'])->name('quizzes.show');
            Route::delete('/quizzes/destroy/{id}', [QuizzController::class, 'destroy'])->name('quizzes.destroy');

            Route::post('/questions/store', [QuestionController::class, 'store'])->name('questions.store');
            Route::get('/questions/show/{id}', [QuestionController::class, 'show'])->name('questions.show');
            Route::get('/questions/edit/{id}',  [QuestionController::class, 'edit'])->name('questions.edit');
            Route::put('/questions/update/{id}', [QuestionController::class, 'update'])->name('questions.update');
            Route::delete('/questions/destroy/{id}', [QuestionController::class, 'destroy'])->name('questions.destroy');

            // Route::get('/Get_classrooms/{id}', [QuizzController::class, 'getClassrooms'])->name('getClassrooms');
            // Route::get('/Get_Sections/{id}', [QuizzController::class, 'Get_Sections'])->name('Get_Sections');
        });


    }
);
