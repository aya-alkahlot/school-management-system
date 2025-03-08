<?php

namespace App\Http\Requests\Quizz;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizze extends FormRequest
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
            'Name_ar' => 'required|string|max:255',
            'Name_en' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'Grade_id' => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'teacher_id' => 'required|exists:teachers,id',
        ];
    }
}
