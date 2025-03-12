<?php

namespace App\Http\Requests\Students\Libraries;

use Illuminate\Foundation\Http\FormRequest;

class StoreLibraries extends FormRequest
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
            'title' => 'required|string|max:255',
            'file_name' => 'required|file|mimes:pdf,doc,docx|max:2048', // يجب أن يكون ملفًا فعليًا
            'Grade_id' => 'required|integer',
            'Classroom_id' => 'required|integer',
            'section_id' => 'required|integer',
        ];
    }
    
    public function messages()
    {
        return [
            'title.required' => 'يجب إدخال عنوان الكتاب.',
            'file_name.required' => 'يجب تحميل ملف الكتاب.',
            'Grade_id.required' => 'يجب تحديد المرحلة الدراسية.',
            'Classroom_id.required' => 'يجب تحديد الصف الدراسي.',
            'section_id.required' => 'يجب تحديد القسم.',
        ];
    }
}