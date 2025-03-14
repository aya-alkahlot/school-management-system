<?php

namespace App\Http\Requests\Students\dashboard\Exams;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExams extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'subject_id' => 'sometimes|exists:subjects,id',
            'grade_id' => 'sometimes|exists:grades,id',
            'classroom_id' => 'sometimes|exists:classrooms,id',
            'section_id' => 'sometimes|exists:sections,id',
            'teacher_id' => 'sometimes|exists:teachers,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'يجب إدخال اسم الامتحان.',
            'subject_id.required' => 'يجب تحديد المادة.',
            'grade_id.required' => 'يجب تحديد المرحلة الدراسية.',
            'classroom_id.required' => 'يجب تحديد الفصل الدراسي.',
            'section_id.required' => 'يجب تحديد القسم.',
            'teacher_id.required' => 'يجب تحديد المعلم.',
        ];
    }
}