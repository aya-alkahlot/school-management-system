<?php

namespace App\Http\Requests\Students\Graduates;

use Illuminate\Foundation\Http\FormRequest;

class StoreGraduates extends FormRequest
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
            'Grade_id' => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
        ];
    }

    public function messages()
    {
        return [
            'Grade_id.required' => 'يجب تحديد المرحلة الدراسية.',
            'Grade_id.exists' => 'المرحلة الدراسية المحددة غير موجودة.',
            'Classroom_id.required' => 'يجب تحديد الفصل الدراسي.',
            'Classroom_id.exists' => 'الفصل الدراسي المحدد غير موجود.',
            'section_id.required' => 'يجب تحديد القسم.',
            'section_id.exists' => 'القسم المحدد غير موجود.',
        ];
    }
}