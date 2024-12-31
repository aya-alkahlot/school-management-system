<?php

use Livewire\Livewire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Exams\ExamController;
use App\Http\Controllers\Grades\GradeController;
use App\Http\Controllers\Students\FeesController;
use App\Http\Controllers\Sections\SectionController;
use App\Http\Controllers\Students\PaymentController;
use App\Http\Controllers\Students\StudentController;
use App\Http\Controllers\Subjects\SubjectController;
use App\Http\Controllers\Teachers\TeacherController;
use App\Http\Controllers\Students\GraduatedController;
use App\Http\Controllers\Students\PromotionController;
use App\Http\Controllers\Students\AttendanceController;
use App\Http\Controllers\Classrooms\ClassroomController;
use App\Http\Controllers\Students\FeesInvoicesController;
use App\Http\Controllers\Students\ProcessingFeeController;
use App\Http\Controllers\Students\ReceiptStudentController;
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
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');


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
    });
    //==============================End dashboard page of Sections============================

    //==============================parents============================

    Route::view('add_parent', 'livewire.show_Form');

    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/en/livewire/update', $handle);
    });
    //==============================Start dashboard page of Teacher============================
    Route::group(['prefix' => 'Teachers'], function () {
        Route::get('/Teachers', [TeacherController::class, 'index'])->name('Teachers.index');
        Route::get('/Teachers/create',  [TeacherController::class, 'create'])->name('Teachers.create');
        Route::post('/Teachers/store', [TeacherController::class, 'store'])->name('Teachers.store');
        Route::get('/edit/{id}', [TeacherController::class, 'edit'])->name('Teachers.edit');
        Route::patch('/update', [TeacherController::class, 'Update'])->name('Teachers.update');
        Route::delete('/Teachers/destroy', [TeacherController::class, 'destroy'])->name('Teachers.destroy');
    });
    //==============================End dashboard page of Teacher============================
    //==============================Start Students page of Students============================

    Route::group(['prefix' => 'Students'], function () {
        Route::get('/Students', [StudentController::class, 'index'])->name('Students.index');
        Route::get('/Students/create',  [StudentController::class, 'create'])->name('Students.create');
        Route::get('/Get_classrooms/{id}',  [StudentController::class, 'Get_classrooms']);
        Route::get('/Get_Sections/{id}',  [StudentController::class, 'Get_Sections']);
        Route::post('/Students/store', [StudentController::class, 'store'])->name('Students.store');
        Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('Students.edit');
        Route::get('/students/{id}', [StudentController::class, 'show'])->name('Students.show');
        Route::put('/Students/update', [StudentController::class, 'Update'])->name('Students.update');
        Route::delete('/Students/destroy', [StudentController::class, 'destroy'])->name('Students.destroy');
        Route::post('Upload_attachment', [StudentController::class, 'Upload_attachment'])->name('Upload_attachment');
        Route::post('Delete_attachment', [StudentController::class, 'Delete_attachment'])->name('Delete_attachment');
    });
    Route::get('/Download_attachment/{studentsname}/{filename}', [StudentController::class, 'Download_attachment'])->name('Download_attachment');
    //==============================End Students page of Students============================
    //==============================Start Pormotion page of Students============================
    Route::group(['prefix' => 'Promotion'], function () {
        Route::get('/Promotion', [PromotionController::class, 'index'])->name('Promotion.index');
        Route::post('/Promotion/store', [PromotionController::class, 'store'])->name('Promotion.store');
        Route::get('/Promotion/create',  [PromotionController::class, 'create'])->name('Promotion.create');
        Route::delete('/Promotion/destroy', [PromotionController::class, 'destroy'])->name('Promotion.destroy');
    });
    //==============================End Pormotion page of Students============================

    Route::group(['prefix' => 'Graduated'], function () {
        Route::get('/Graduated', [GraduatedController::class, 'index'])->name('Graduated.index');
        Route::post('/Graduated/store', [GraduatedController::class, 'store'])->name('Graduated.store');
        Route::get('/Graduated/create',  [GraduatedController::class, 'create'])->name('Graduated.create');
        Route::put('/Graduated/update', [GraduatedController::class, 'Update'])->name('Graduated.update');
        Route::delete('/Graduated/destroy', [GraduatedController::class, 'destroy'])->name('Graduated.destroy');

    });

    Route::group(['prefix' => 'Fees'], function () {
        Route::get('/Fees', [FeesController::class, 'index'])->name('Fees.index');
        Route::post('/Fees/store', [FeesController::class, 'store'])->name('Fees.store');
        Route::get('/Fees/create',  [FeesController::class, 'create'])->name('Fees.create');
        Route::get('/edit/{id}', [FeesController::class, 'edit'])->name('Fees.edit');
        Route::put('/Fees/update', [FeesController::class, 'Update'])->name('Fees.update');
        Route::delete('/Fees/destroy', [FeesController::class, 'destroy'])->name('Fees.destroy');

    });

    Route::group(['prefix' => 'Fees_Invoice'], function () {
        Route::get('/Fees_Invoice', [FeesInvoicesController::class, 'index'])->name('Fees_Invoices.index');
        Route::get('/Fees_Invoice/{id}', [FeesInvoicesController::class, 'show'])->name('Fees_Invoices.show');
        Route::post('/Fees_Invoice/store', [FeesInvoicesController::class, 'store'])->name('Fees_Invoices.store');
        Route::get('/edit/{id}', [FeesInvoicesController::class, 'edit'])->name('Fees_Invoices.edit');
        Route::put('/Fees_Invoice/update', [FeesInvoicesController::class, 'update'])->name('Fees_Invoices.update');
        Route::delete('/Fees_Invoice/destroy', [FeesInvoicesController::class, 'destroy'])->name('Fees_Invoices.destroy');

    });
    Route::group(['prefix' => 'receipt_student'], function () {
        Route::get('/receipt_student', [ReceiptStudentController::class, 'index'])->name('receipt_students.index');
        Route::get('/receipt_students/{id}', [ReceiptStudentController::class, 'show'])->name('receipt_students.show');
        Route::post('/receipt_students/store', [ReceiptStudentController::class, 'store'])->name('receipt_students.store');
        Route::get('/edit/{id}', [ReceiptStudentController::class, 'edit'])->name('receipt_students.edit');
        Route::put('/receipt_students/update', [ReceiptStudentController::class, 'update'])->name('receipt_students.update');
        Route::delete('/receipt_students/destroy', [ReceiptStudentController::class, 'destroy'])->name('receipt_students.destroy');

    });
    Route::group(['prefix' => 'ProcessingFee'], function () {
        Route::get('/ProcessingFee', [ProcessingFeeController::class, 'index'])->name('ProcessingFee.index');
        Route::get('/ProcessingFee/{id}', [ProcessingFeeController::class, 'show'])->name('ProcessingFee.show');
        Route::post('/ProcessingFee/store', [ProcessingFeeController::class, 'store'])->name('ProcessingFee.store');
        Route::get('/edit/{id}', [ProcessingFeeController::class, 'edit'])->name('ProcessingFee.edit');
        Route::put('/ProcessingFee/update', [ProcessingFeeController::class, 'update'])->name('ProcessingFee.update');
        Route::delete('/ProcessingFee/destroy', [ProcessingFeeController::class, 'destroy'])->name('ProcessingFee.destroy');

    });
    Route::group(['prefix' => 'PaymentStudent'], function () {
        Route::get('/PaymentStudent', [PaymentController::class, 'index'])->name('Payment_students.index');
        Route::get('/ProcessingFee/{id}', [PaymentController::class, 'show'])->name('Payment_students.show');
        Route::post('/ProcessingFee/store', [PaymentController::class, 'store'])->name('Payment_students.store');
        Route::get('/edit/{id}', [PaymentController::class, 'edit'])->name('Payment_students.edit');
        Route::put('/ProcessingFee/update', [PaymentController::class, 'update'])->name('Payment_students.update');
        Route::delete('/ProcessingFee/destroy', [PaymentController::class, 'destroy'])->name('Payment_students.destroy');

    });
    Route::group(['prefix' => 'Attendance'], function () {
        Route::get('/Attendance', [AttendanceController::class, 'index'])->name('Attendance.index');
        Route::get('/Attendance/{id}', [AttendanceController::class, 'show'])->name('Attendance.show');
        Route::post('/Attendance/store', [AttendanceController::class, 'store'])->name('Attendance.store');
        // Route::get('/edit/{id}', [AttendanceController::class, 'edit'])->name('Attendance.edit');
        // Route::put('/Attendance/update', [AttendanceController::class, 'update'])->name('Attendance.update');
        // Route::delete('/Attendance/destroy', [AttendanceController::class, 'destroy'])->name('Attendance.destroy');

    });
    Route::group(['prefix' => 'Subjects'], function () {
        Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
        Route::get('/subjects/create',  [SubjectController::class, 'create'])->name('subjects.create');
        Route::get('/subjects/{id}', [SubjectController::class, 'show'])->name('subjects.show');
        Route::post('/subjects/store', [SubjectController::class, 'store'])->name('subjects.store');
        Route::get('/edit/{id}', [SubjectController::class, 'edit'])->name('subjects.edit');
        Route::Patch('/subjects/update', [SubjectController::class, 'update'])->name('subjects.update');
        Route::delete('/subjects/destroy', [SubjectController::class, 'destroy'])->name('subjects.destroy');

    });

    Route::group(['prefix' => 'Exams'], function () {
        Route::get('/Exams', [ExamController::class, 'index'])->name('Exams.index');
        Route::get('/Exams/create',  [ExamController::class, 'create'])->name('Exams.create');
        Route::post('/Exams/store', [ExamController::class, 'store'])->name('Exams.store');
        Route::get('/edit/{id}', [ExamController::class, 'edit'])->name('Exams.edit');
        Route::Patch('/Exams/update', [ExamController::class, 'update'])->name('Exams.update');
        Route::delete('/Exams/destroy', [ExamController::class, 'destroy'])->name('Exams.destroy');

    });



});
