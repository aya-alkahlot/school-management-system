<?php

namespace App\Http\Requests\Classrooms;

use Illuminate\Foundation\Http\FormRequest;

class DeleteAllClassrooms extends FormRequest
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
            'delete_all_id' => 'required|string',
        ];
    }

    /**
     * Get custom messages for validation errors.
     */
    public function messages()
    {
        return [
            'delete_all_id.required' => 'يجب تحديد قائمة الفصول الدراسية.',
        ];
    }
}