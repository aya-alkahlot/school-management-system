<?php

namespace App\Http\Controllers\backend\Api\Teachers\dashboard;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Teachers\dashboard\Questions\StoreQuestionRequest;
use App\Http\Requests\Teachers\dashboard\Questions\UpdateQuestionRequest;

class TeacherApiQuestionController extends Controller
{
    public function index()
    {
        $questions = Question::all();
        return response()->json(['status_code' => 200, 'data' => $questions]);
    }

    public function store(StoreQuestionRequest $request)
    {
        try {
            $question = Question::create([
                'title' => $request->title,
                'answers' => $request->answers,
                'right_answer' => $request->right_answer,
                'score' => $request->score,
                'quizze_id' => $request->quizze_id,  // تأكد من أن الاسم هنا هو quizze_id
            ]);
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Question created successfully',
                'data' => $question,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error creating question',
                'error' => $e->getMessage(),
            ]);
        }
    }
    
    public function show($id)
    {
        $question = Question::find($id);
        if (!$question) {
            return response()->json(['status_code' => 404, 'message' => 'Question not found']);
        }

        return response()->json(['status_code' => 200, 'data' => $question]);
    }
    
    public function update(UpdateQuestionRequest $request, $id)
    {
        try {
            $question = Question::findOrFail($id);
            $question->update([
                'title' => $request->title,
                'answers' => $request->answers,
                'right_answer' => $request->right_answer,
                'score' => $request->score,
            ]);

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Question updated successfully',
                'data' => $question,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'Error updating question',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            Question::destroy($id);
            return response()->json(['status_code' => 200, 'message' => 'Question deleted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'status_code' => 500, 'message' => 'Error deleting question', 'error' => $e->getMessage()]);
        }
    }
}
