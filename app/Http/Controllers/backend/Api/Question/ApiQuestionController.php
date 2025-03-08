<?php

namespace App\Http\Controllers\backend\Api\Question;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Questions\StoreQuestions;
use App\Http\Requests\Questions\UpdateQuestions;

class ApiQuestionController extends Controller
{
    
    public function index()
    {
        $questions = Question::all();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'List of Questions | قائمة الأسئلة',
            'data' => $questions,
        ]);
    }

    /**
     * إنشاء سؤال جديد.
     */
    public function store(StoreQuestions $request)
    {
        try {
            $validated = $request->validated();
            $question = new Question();
            $question->title = $request->title;
            $question->answers = $request->answers;
            $question->right_answer = $request->right_answer;
            $question->score = $request->score;
            $question->quizze_id = $request->quizze_id;
            $question->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Question created successfully | تم إنشاء السؤال بنجاح',
                'data' => $question,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating question | حدث خطأ أثناء إنشاء السؤال',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * تحديث سؤال محدد.
     */
    public function update(UpdateQuestions $request, $id)
    {
        try {
            $question = Question::find($id);
            if (!$question) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Question not found | لم يتم العثور على السؤال',
                ]);
            }

            $question->update([
                'title' => $request->title,
                'answers' => $request->answers,
                'right_answer' => $request->right_answer,
                'score' => $request->score,
                'quizze_id' => $request->quizze_id,
            ]);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Question updated successfully | تم تحديث السؤال بنجاح',
                'data' => $question,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating question | حدث خطأ أثناء تحديث السؤال',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * حذف سؤال محدد.
     */
    public function destroy($id)
    {
        try {
            $question = Question::find($id);
            if (!$question) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Question not found | لم يتم العثور على السؤال',
                ]);
            }

            $question->delete();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Question deleted successfully | تم حذف السؤال بنجاح',
                'data' => $question,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error deleting question | حدث خطأ أثناء حذف السؤال',
                'error' => $e->getMessage(),
            ]);
        }
    }
}
