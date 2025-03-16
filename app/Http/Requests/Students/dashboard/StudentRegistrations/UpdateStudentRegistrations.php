<?php

namespace App\Http\Requests\Students\dashboard\StudentRegistrations;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRegistrations extends FormRequest
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
            'student_id' => 'sometimes|required|exists:students,id',
            'subject_id' => 'sometimes|required|exists:subjects,id',
            'teacher_id' => 'sometimes|required|exists:teachers,id',
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'يجب تحديد الطالب.',
            'student_id.exists' => 'الطالب المحدد غير موجود.',
            'subject_id.required' => 'يجب تحديد المادة الدراسية.',
            'subject_id.exists' => 'المادة الدراسية المحددة غير موجودة.',
            'teacher_id.required' => 'يجب تحديد المعلم.',
            'teacher_id.exists' => 'المعلم المحدد غير موجود.',
        ];
    }
}