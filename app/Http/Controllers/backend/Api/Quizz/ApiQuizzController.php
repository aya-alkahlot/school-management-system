<?php

namespace App\Http\Controllers\backend\Api\Quizz;

use App\Models\Quizze;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Quizz\StoreQuizze;
use App\Http\Requests\Quizz\UpdateQuizze;

class ApiQuizzController extends Controller
{
        /**
     * عرض جميع الاختبارات.
     */
    public function index()
    {
        $quizzes = Quizze::all();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Quizzes | قائمة الاختبارات',
            'data' => $quizzes,
        ]);
    }

    /**
     * إنشاء اختبار جديد.
     */
    public function store(StoreQuizze $request)
    {
        try {
            $validated = $request->validated();
            $quizze = new Quizze();
            $quizze->name = ['en' => $request->Name_en, 'ar' => $request->Name_ar];
            $quizze->subject_id = $request->subject_id;
            $quizze->grade_id = $request->Grade_id;
            $quizze->classroom_id = $request->Classroom_id;
            $quizze->section_id = $request->section_id;
            $quizze->teacher_id = $request->teacher_id;
            $quizze->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Quiz created successfully | تم إنشاء الاختبار بنجاح',
                'data' => $quizze,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating quiz | حدث خطأ أثناء إنشاء الاختبار',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * تحديث اختبار محدد.
     */
    public function update(UpdateQuizze $request, $id)
    {
        try {
            $quizze = Quizze::find($id);
            if (!$quizze) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Quiz not found | لم يتم العثور على الاختبار',
                ]);
            }

            $quizze->update([
                'name' => ['en' => $request->Name_en, 'ar' => $request->Name_ar],
                'subject_id' => $request->subject_id,
                'grade_id' => $request->Grade_id,
                'classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'teacher_id' => $request->teacher_id,
            ]);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Quiz updated successfully | تم تحديث الاختبار بنجاح',
                'data' => $quizze,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating quiz | حدث خطأ أثناء تحديث الاختبار',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * حذف اختبار محدد.
     */
    public function destroy($id)
    {
        try {
            $quizze = Quizze::find($id);
            if (!$quizze) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Quiz not found | لم يتم العثور على الاختبار',
                ]);
            }

            $quizze->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Quiz deleted successfully | تم حذف الاختبار بنجاح',
                'data' => $quizze,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting quiz | حدث خطأ أثناء حذف الاختبار',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
