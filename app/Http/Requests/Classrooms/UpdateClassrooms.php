<?php

namespace App\Http\Requests\Classrooms;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassrooms extends FormRequest
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
            'Name' => 'sometimes|string|max:255',
            'Name_en' => 'sometimes|string|max:255',
            'Grade_id' => 'sometimes|exists:grades,id',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages()
    {
        return [
            'Name.required' => 'يجب إدخال اسم الفصل باللغة العربية.',
            'Name_en.required' => 'يجب إدخال اسم الفصل باللغة الإنجليزية.',
            'Grade_id.required' => 'يجب اختيار المرحلة الدراسية.',
            'Grade_id.exists' => 'المرحلة الدراسية المحددة غير موجودة.',
        ];
    }
}