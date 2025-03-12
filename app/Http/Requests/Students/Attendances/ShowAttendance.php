<?php

namespace App\Http\Requests\Students\Attendances;

use Illuminate\Foundation\Http\FormRequest;

class ShowAttendance extends FormRequest
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
            'id' => 'required|exists:attendances,id',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'يجب تحديد سجل الحضور.',
            'id.exists' => 'سجل الحضور غير موجود.',
        ];
    }
}