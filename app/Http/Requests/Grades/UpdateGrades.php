<?php

namespace App\Http\Requests\Grades;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrades extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'Name' => 'required|string|max:255',
            'Name_en' => 'required|string|max:255',
            'Notes' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'Name.required' => 'يجب إدخال اسم المرحلة الدراسية باللغة العربية.',
            'Name_en.required' => 'يجب إدخال اسم المرحلة الدراسية باللغة الإنجليزية.',
        ];
    }
}
