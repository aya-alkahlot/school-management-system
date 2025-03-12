<?php

namespace App\Http\Requests\Students\Attendances;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendances extends FormRequest
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
            'student_id' => 'required|exists:students,id',
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'teacher_id' => 'required|exists:teachers,id',
            'attendence_date' => 'required|date',
            'attendence_status' => 'required|integer|in:0,1', // تأكد من أن القيم تتطابق مع القيم في قاعدة البيانات
        ];
    }
    

    /**
     * Custom error messages
     */
    public function messages()
    {
        return [
            'student_id.required' => 'يجب تحديد الطالب.',
            'student_id.exists' => 'الطالب غير موجود في النظام.',

            'grade_id.required' => 'يجب تحديد المرحلة الدراسية.',
            'grade_id.exists' => 'المرحلة الدراسية غير موجودة في النظام.',

            'classroom_id.required' => 'يجب تحديد الصف الدراسي.',
            'classroom_id.exists' => 'الصف الدراسي غير موجود في النظام.',

            'section_id.required' => 'يجب تحديد القسم.',
            'section_id.exists' => 'القسم غير موجود في النظام.',

            'teacher_id.required' => 'يجب تحديد المعلم.',
            'teacher_id.exists' => 'المعلم غير موجود في النظام.',

            'attendence_date.required' => 'يجب إدخال تاريخ الحضور.',
            'attendence_date.date' => 'يجب أن يكون التاريخ بتنسيق صحيح (YYYY-MM-DD).',

            'attendence_status.required' => 'يجب تحديد حالة الحضور.',
            'attendence_status.in' => 'يجب أن تكون الحالة: حاضر (present)، غائب (absent)، متأخر (late)، أو معذور (excused).',

            'attendence_status.required' => 'يجب تحديد حالة الحضور.',
            'attendence_status.integer' => 'يجب أن تكون حالة الحضور رقمية.',
            'attendence_status.in' => 'يجب أن تكون حالة الحضور: 0 (غائب), 1 (حاضر), 2 (متأخر), أو 3 (معذور).',
        ];
    }
}