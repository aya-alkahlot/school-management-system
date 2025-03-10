<?php

namespace App\Http\Requests\Students\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendance extends FormRequest
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
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'teacher_id' => 'required|exists:teachers,id',
            'attendences' => 'required|array',
            'attendences.*' => 'in:presence,absent',
            'attendence_date' => 'nullable|date', // ✅ أضف هذا السطر
        ];
    }
    
    public function messages()
    {
        return [
            'teacher_id.required' => 'يجب تحديد المعلم المسؤول عن تسجيل الحضور.',
            'teacher_id.exists' => 'المعلم المحدد غير موجود في النظام.',
        ];
    }}