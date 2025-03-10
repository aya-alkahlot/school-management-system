<?php

namespace App\Http\Requests\Students\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendance extends FormRequest
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
            'attendance_status' => 'required|boolean',
        ];
    }

    public function messages()
    {
        return [
            'attendance_status.required' => 'يجب تحديد حالة الحضور.',
            'attendance_status.boolean' => 'يجب أن تكون الحالة إما `true` للحضور أو `false` للغياب.',
        ];
    }
}
