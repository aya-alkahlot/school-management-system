<?php

namespace App\Http\Requests\Teachers\dashboard\Questions;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'right_answer' => 'required|string',
            'score' => 'required|numeric|min:0',
            'quizze_id' => 'required|exists:quizzes,id',
        ];
    }
}
