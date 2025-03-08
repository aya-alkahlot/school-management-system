<?php

namespace App\Http\Requests\Classrooms;

use Illuminate\Foundation\Http\FormRequest;

class DeleteClassrooms extends FormRequest
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
            'id' => 'required|exists:classrooms,id',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages()
    {
        return [
            'id.required' => 'يجب تحديد الفصل الدراسي.',
            'id.exists' => 'الفصل الدراسي المحدد غير موجود.',
        ];
    }
}