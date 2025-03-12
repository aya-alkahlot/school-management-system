<?php

namespace App\Http\Requests\Students\OnlineClasses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOnlineClass extends FormRequest
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
            'Grade_id' => 'sometimes|exists:grades,id',
            'Classroom_id' => 'sometimes|exists:classrooms,id',
            'section_id' => 'sometimes|exists:sections,id',
            'topic' => 'sometimes|string|max:255',
            'start_at' => 'sometimes|date',
            'duration' => 'sometimes|integer|min:1',
            'password' => 'sometimes|string|max:10',
            'start_url' => 'sometimes|url',
            'join_url' => 'sometimes|url',
            'meeting_id' => 'nullable|string',
            'integration' => 'sometimes|boolean',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages()
    {
        return [
            'Grade_id.exists' => 'المرحلة الدراسية غير موجودة في النظام.',

            'Classroom_id.exists' => 'الصف الدراسي غير موجود في النظام.',

            'section_id.exists' => 'القسم غير موجود في النظام.',

            'topic.string' => 'يجب أن يكون العنوان نصيًا.',
            'topic.max' => 'يجب ألا يتجاوز العنوان 255 حرفًا.',

            'start_at.date' => 'يجب أن يكون التاريخ بصيغة صحيحة.',

            'duration.integer' => 'يجب أن تكون المدة رقمًا صحيحًا.',
            'duration.min' => 'يجب ألا تقل مدة الحصة عن دقيقة واحدة.',

            'password.string' => 'يجب أن تكون كلمة المرور نصية.',
            'password.max' => 'يجب ألا تزيد كلمة المرور عن 10 أحرف.',

            'start_url.url' => 'يجب أن يكون الرابط صحيحًا.',

            'join_url.url' => 'يجب أن يكون الرابط صحيحًا.',

            'meeting_id.string' => 'يجب أن يكون معرف الاجتماع نصيًا.',

            'integration.boolean' => 'يجب أن تكون قيمة التكامل إما true أو false.',
        ];
    }
}