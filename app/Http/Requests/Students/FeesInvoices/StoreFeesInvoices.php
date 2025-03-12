<?php

namespace App\Http\Requests\Students\FeesInvoices;

use Illuminate\Foundation\Http\FormRequest;

class StoreFeesInvoices extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // السماح لجميع المستخدمين المخوّلين بتنفيذ العملية
    }

    /**
     * قواعد التحقق من البيانات المدخلة.
     */
    public function rules(): array
    {
        return [
            'invoice_date' => 'required|date', 
            'student_id' => 'required|exists:students,id', 
            'Grade_id' => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'fee_id' => 'required|exists:fees,id',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
        ];
    }

    /**
     * رسائل الأخطاء المخصصة.
     */
    public function messages()
    {
        return [
            'invoice_date.required' => 'يجب إدخال تاريخ الفاتورة.',
            'invoice_date.date' => 'تنسيق تاريخ الفاتورة غير صالح.',

            'student_id.required' => 'يجب تحديد الطالب.',
            'student_id.exists' => 'الطالب غير موجود في النظام.',

            'Grade_id.required' => 'يجب تحديد المرحلة الدراسية.',
            'Grade_id.exists' => 'المرحلة الدراسية غير موجودة.',

            'Classroom_id.required' => 'يجب تحديد الصف الدراسي.',
            'Classroom_id.exists' => 'الصف الدراسي غير موجود.',

            'fee_id.required' => 'يجب تحديد نوع الرسوم.',
            'fee_id.exists' => 'الرسوم غير موجودة في النظام.',

            'amount.required' => 'يجب إدخال المبلغ.',
            'amount.numeric' => 'يجب أن يكون المبلغ رقماً.',
            'amount.min' => 'يجب ألا يكون المبلغ أقل من 0.',

            'description.string' => 'يجب أن يكون الوصف نصاً.',
            'description.max' => 'يجب ألا يتجاوز الوصف 255 حرفاً.',
        ];
    }
}