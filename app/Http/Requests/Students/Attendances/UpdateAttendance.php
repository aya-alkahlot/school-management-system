<?php

namespace App\Http\Requests\Students\Attendances;

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

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'status' => 'required|in:present,absent,late,excused',
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'يجب تحديد حالة الحضور.',
            'status.in' => 'يجب أن تكون الحالة: present, absent, late, أو excused.',
        ];
    }
}