<?php

namespace App\Http\Requests\Students\Fees;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFeesRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title.en' => [
                'required',
                'string',
                'max:255',
                Rule::unique('fees', 'title->en'),
            ],
            'title.ar' => 'required|string|max:255|regex:/^[\p{Arabic}\s]+$/u', // تحقق من النصوص العربية
            'amount' => 'required|numeric|min:0',
            'Grade_id' => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'year' => 'required|digits:4',
            'description' => 'nullable|string',
            'Fee_type' => 'required|integer',
        ];
    }
    /**
     * Custom error messages
     */
    public function messages()
    {
        return [
            'title.required' => 'يجب إدخال عنوان الرسوم.',
            'title_en.required' => 'يجب إدخال عنوان الرسوم باللغة الإنجليزية.',
            'title_ar.required' => 'يجب إدخال عنوان الرسوم باللغة العربية.',
            'amount.required' => 'يجب إدخال المبلغ.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'Grade_id.required' => 'يجب تحديد المرحلة الدراسية.',
            'Grade_id.exists' => 'المرحلة الدراسية غير موجودة في النظام.',
            'Classroom_id.required' => 'يجب تحديد الصف الدراسي.',
            'Classroom_id.exists' => 'الصف الدراسي غير موجود في النظام.',
            'year.required' => 'يجب إدخال السنة الدراسية.',
            'Fee_type.required' => 'يجب تحديد نوع الرسوم.',
            'Fee_type.in' => 'نوع الرسوم يجب أن يكون: fixed أو variable.',
        ];
    }
}