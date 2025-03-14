<?php

namespace App\Http\Controllers\backend\Api\Students\dashboard\Exams;

use App\Models\Quizze;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Students\dashboard\Exams\StoreExams;
use App\Http\Requests\Students\dashboard\Exams\UpdateExams;

class ApiExamController extends Controller
{
    public function index()
    {
        // ✅ التحقق مما إذا كان المستخدم مسجل الدخول
        if (!Auth::check()) {
            return response()->json([
                'status_code' => 401,
                'status_message' => 'User is not authenticated | المستخدم غير مصادق عليه',
            ], 401);
        }

        $user = Auth::user();

        $quizzes = Quizze::where('grade_id', $user->Grade_id)
            ->where('classroom_id', $user->Classroom_id)
            ->where('section_id', $user->section_id)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Exams | قائمة الامتحانات',
            'data' => $quizzes,
        ]);
    }

    /**
     * عرض امتحان محدد.
     */
    public function show($quizze_id)
    {
        try {
            $quizze = Quizze::findOrFail($quizze_id);
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Exam details | تفاصيل الامتحان',
                'data' => $quizze,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Exam not found | لم يتم العثور على الامتحان',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * إنشاء امتحان جديد.
     */
    public function store(StoreExams $request)
    {
        try {
            $validated = $request->validated();
            $quizze = Quizze::create($validated);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Exam created successfully | تم إنشاء الامتحان بنجاح',
                'data' => $quizze,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating exam | حدث خطأ أثناء إنشاء الامتحان',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * تحديث امتحان محدد.
     */
    public function update(UpdateExams $request, $quizze_id)
    {
        try {
            $quizze = Quizze::findOrFail($quizze_id);
            $quizze->update($request->validated());

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Exam updated successfully | تم تحديث الامتحان بنجاح',
                'data' => $quizze,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Exam not found or update failed | لم يتم العثور على الامتحان أو فشل التحديث',
                'error' => $e->getMessage(),
            ], 404);
        }
    }

    /**
     * حذف امتحان محدد.
     */
    public function destroy($quizze_id)
    {
        try {
            $quizze = Quizze::findOrFail($quizze_id);
            $quizze->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Exam deleted successfully | تم حذف الامتحان بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'Exam not found or delete failed | لم يتم العثور على الامتحان أو فشل الحذف',
                'error' => $e->getMessage(),
            ], 404);
        }
    }
}