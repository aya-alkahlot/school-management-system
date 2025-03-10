<?php

namespace App\Http\Requests\Students\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class DeleteAttendance extends FormRequest
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
            'id' => 'required|exists:attendances,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'يجب تحديد معرف سجل الحضور.',
            'id.exists' => 'سجل الحضور المحدد غير موجود.',
        ];
    }
}
