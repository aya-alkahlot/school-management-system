<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\Api\Quizz\ApiQuizzController;
use App\Http\Controllers\backend\Api\Grades\ApiGradeController;
use App\Http\Controllers\backend\Api\Sections\ApiSectionController;
use App\Http\Controllers\backend\Api\Subjects\ApiSubjectController;
use App\Http\Controllers\backend\Api\Teachers\ApiTeacherController;
use App\Http\Controllers\backend\Api\Question\ApiQuestionController;
use App\Http\Controllers\backend\Api\Students\Fees\ApiFeesController;
use App\Http\Controllers\backend\Api\Classroms\ApiClassroomController;
use App\Http\Controllers\backend\Api\Students\Payments\ApiPaymentController;
use App\Http\Controllers\backend\Api\Teachers\dashboard\ApiStudentController;
use App\Http\Controllers\backend\Api\Students\Promotions\ApiPromotionController;
use App\Http\Controllers\backend\Api\Students\Attendances\ApiAttendanceController;
use App\Http\Controllers\backend\Api\Students\OnlineClasses\ApiOnlineClasseController;
use App\Http\Controllers\backend\Api\Students\ProcessingFees\ApiProcessingFeeController;

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


// ***************************************Start Routes for teachers API ************************************
Route::apiResource('/teachers', ApiTeacherController::class);
Route::delete('/teachers/delete_all', [ApiTeacherController::class, 'delete_all']);

// ***************************************Start Routes for dashboard Students API ********************************
Route::middleware('auth:sanctum')->get('/students', [ApiStudentController::class, 'index']);
Route::post('/students/attendance', [ApiStudentController::class, 'attendance']);
Route::get('/students/attendance-report', [ApiStudentController::class, 'attendanceReport']);
// ***************************************End Routes for dashboard Students API **********************************
// ***************************************End Routes for teachers API **************************************


// *************************************** Start Routes for Attendance API [Student Dashboard] ************************************
Route::prefix('attendances')->group(function () {
    Route::get('/', [ApiAttendanceController::class, 'index']); // عرض جميع سجلات الحضور
    Route::post('/', [ApiAttendanceController::class, 'store']); // إضافة سجل حضور جديد
    Route::get('/{id}', [ApiAttendanceController::class, 'show']); // عرض تفاصيل سجل حضور محدد
    Route::put('/{id}', [ApiAttendanceController::class, 'update']); // تحديث سجل حضور محدد
    Route::delete('/{id}', [ApiAttendanceController::class, 'destroy']); // حذف سجل حضور محدد
});

// Route::apiResource('/attendances', ApiTeacherController::class);

// *************************************** End Routes for Attendance API [Student Dashboard] **************************************
// *************************************** Start Routes for Fees API [Student Dashboard]************************************
Route::prefix('fees')->group(function () {
    Route::get('/', [ApiFeesController::class, 'index']);   
    Route::post('/', [ApiFeesController::class, 'store']);   
    Route::get('/{id}', [ApiFeesController::class, 'show']);  
    Route::put('/{id}', [ApiFeesController::class, 'update']); 
    Route::delete('/{id}', [ApiFeesController::class, 'destroy']); 
});
// *************************************** End Routes for Fees API [Student Dashboard] **************************************

    Route::prefix( 'online-classes')->group(function () {
        Route::get('/', [ApiOnlineClasseController::class, 'index']); // عرض جميع الحصص
        Route::post('/', [ApiOnlineClasseController::class, 'store']); // إنشاء حصة جديدة
        Route::get('/{id}', [ApiOnlineClasseController::class, 'show']); // عرض حصة محددة
        Route::put('/{id}', [ApiOnlineClasseController::class, 'update']); // تحديث بيانات الحصة
        Route::delete('/{id}', [ApiOnlineClasseController::class, 'destroy']); // حذف الحصة
    
});

Route::prefix('payments')->group(function () {
    Route::get('/', [ApiPaymentController::class, 'index']); // عرض جميع المدفوعات
    Route::post('/store', [ApiPaymentController::class, 'store']); // إنشاء مدفوع جديد
    Route::put('/update/{id}', [ApiPaymentController::class, 'update']); // تحديث مدفوع معين
    Route::delete('/delete/{id}', [ApiPaymentController::class, 'destroy']); // حذف مدفوع معين
});

Route::prefix('processing-fees')->group(function () {
    Route::get('/', [ApiProcessingFeeController::class, 'index']); // جلب جميع رسوم المعالجة
    Route::post('/', [ApiProcessingFeeController::class, 'store']); // إنشاء رسوم معالجة جديدة
    Route::put('/{id}', [ApiProcessingFeeController::class, 'update']); // تحديث رسوم معالجة
    Route::delete('/{id}', [ApiProcessingFeeController::class, 'destroy']); // حذف رسوم معالجة
});

Route::prefix('promotions')->group(function () {
    Route::get('/', [ApiPromotionController::class, 'index']); // عرض جميع الترقيات
    Route::post('/store', [ApiPromotionController::class, 'store']); // إضافة ترقية جديدة
    Route::delete('/delete/{id}', [ApiPromotionController::class, 'destroy']); // حذف ترقية معينة
});