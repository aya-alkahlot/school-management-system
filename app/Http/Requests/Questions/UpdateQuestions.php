<?php

namespace App\Http\Requests\Questions;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestions extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'answers' => 'required|string',
            'right_answer' => 'required|string|max:255',
            'score' => 'required|integer|min:1|max:100',
            'quizze_id' => 'required|exists:quizzes,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'يجب إدخال عنوان السؤال.',
            'answers.required' => 'يجب إدخال الإجابات.',
            'right_answer.required' => 'يجب إدخال الإجابة الصحيحة.',
            'score.required' => 'يجب تحديد درجة السؤال.',
            'quizze_id.required' => 'يجب تحديد الاختبار المرتبط بالسؤال.',
            'quizze_id.exists' => 'الاختبار المحدد غير موجود.',
        ];
    }
}