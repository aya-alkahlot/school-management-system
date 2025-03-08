<?php

namespace App\Http\Requests\Classrooms;

use Illuminate\Foundation\Http\FormRequest;

class FilterClassrooms extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true; // يمكن تغييرها إذا كنت تريد التحقق من الصلاحيات
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules()
    {
        return [
            'Grade_id' => 'required|exists:grades,id',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages()
    {
        return [
            'Grade_id.required' => 'يجب اختيار المرحلة الدراسية.',
            'Grade_id.exists' => 'المرحلة الدراسية المحددة غير موجودة.',
        ];
    }
}