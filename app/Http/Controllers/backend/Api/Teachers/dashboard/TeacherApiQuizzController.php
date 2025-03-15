<?php

namespace App\Http\Controllers\backend\Api\Teachers\dashboard;

use Exception;
use App\Models\Degree;
use App\Models\Quizze;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teachers\dashboard\Quizz\StoreQuizzRequest;
use App\Http\Requests\Teachers\dashboard\Quizz\UpdateQuizzRequest;

class TeacherApiQuizzController extends Controller
{
    public function index()
    {
        $quizzes = Quizze::where('teacher_id', auth()->user()->id)->get();
        return response()->json(['status_code' => 200, 'data' => $quizzes]);
    }

    public function store(StoreQuizzRequest $request)
    {
        try {
            $quizz = Quizze::create([
                'name' => ['en' => $request->Name_en, 'ar' => $request->Name_ar],
                'subject_id' => $request->subject_id,
                'grade_id' => $request->Grade_id,
                'classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'teacher_id' => auth()->user()->id,
            ]);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Quiz created successfully | تم إنشاء الاختبار بنجاح',
                'data' => $quizz,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating quiz | حدث خطأ أثناء إنشاء الاختبار',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function update(UpdateQuizzRequest $request, $id)
    {
        try {
            $quizz = Quizze::findOrFail($id);
            $quizz->update([
                'name' => ['en' => $request->Name_en, 'ar' => $request->Name_ar],
                'subject_id' => $request->subject_id,
                'grade_id' => $request->Grade_id,
                'classroom_id' => $request->Classroom_id,
                'section_id' => $request->section_id,
                'teacher_id' => auth()->user()->id,
            ]);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Quiz updated successfully | تم تحديث الاختبار بنجاح',
                'data' => $quizz,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating quiz | حدث خطأ أثناء تحديث الاختبار',
                'error' => $e->getMessage(),
            ]);
        }
    }


    public function destroy($id)
    {
        try {
            Quizze::destroy($id);
            return response()->json(['status_code' => 200, 'message' => 'Quiz deleted successfully']);
        } catch (Exception $e) {
            return response()->json(['status_code' => 500, 'message' => 'Error deleting quiz', 'error' => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        $quiz = Quizze::find($id);
        if (!$quiz) {
            return response()->json(['status_code' => 404, 'message' => 'Quiz not found']);
        }

        return response()->json(['status_code' => 200, 'data' => $quiz]);
    }


    public function student_quizze($quizze_id)
    {
        $degrees = Degree::where('quizze_id', $quizze_id)->get();
        return response()->json(['status_code' => 200, 'data' => $degrees]);
    }

    public function repeat_quizze(Request $request)
    {
        Degree::where('student_id', $request->student_id)->where('quizze_id', $request->quizze_id)->delete();
        return response()->json(['status_code' => 200, 'message' => 'Quiz reopened for student']);
    }
}