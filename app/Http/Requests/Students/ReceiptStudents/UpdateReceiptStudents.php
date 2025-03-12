<?php

namespace App\Http\Requests\Students\ReceiptStudents;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReceiptStudents extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_id'  => 'required|exists:students,id',
            'Debit'       => 'required|numeric|min:0.01',
            'description' => 'required|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'student_id.required' => 'الطالب مطلوب.',
            'student_id.exists'   => 'الطالب غير موجود في النظام.',
            'Debit.required'      => 'المبلغ مطلوب.',
            'Debit.numeric'       => 'المبلغ يجب أن يكون رقمًا.',
            'Debit.min'           => 'المبلغ يجب أن يكون أكبر من 0.',
            'description.required' => 'الوصف مطلوب.',
            'description.string'   => 'الوصف يجب أن يكون نصًا.',
            'description.max'      => 'الوصف لا يجب أن يتجاوز 500 حرف.',
        ];
    }
}