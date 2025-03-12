<?php

namespace App\Http\Requests\Students\OnlineClasses;

use Illuminate\Foundation\Http\FormRequest;

class StoreOnlineClass extends FormRequest
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
            'Grade_id' => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'topic' => 'required|string|max:255',
            'start_at' => 'required|date',
            'duration' => 'required|integer|min:1',
            'password' => 'required|string|max:10',
            'start_url' => 'required|url',
            'join_url' => 'required|url',
            'meeting_id' => 'nullable|string',
            'integration' => 'required|boolean',
        ];
    }

    /**
     * Custom error messages.
     */
    public function messages()
    {
        return [
            'Grade_id.required' => 'يجب تحديد المرحلة الدراسية.',
            'Grade_id.exists' => 'المرحلة الدراسية غير موجودة في النظام.',

            'Classroom_id.required' => 'يجب تحديد الصف الدراسي.',
            'Classroom_id.exists' => 'الصف الدراسي غير موجود في النظام.',

            'section_id.required' => 'يجب تحديد القسم.',
            'section_id.exists' => 'القسم غير موجود في النظام.',

            'topic.required' => 'يجب إدخال عنوان الحصة.',
            'topic.string' => 'يجب أن يكون العنوان نصيًا.',
            'topic.max' => 'يجب ألا يتجاوز العنوان 255 حرفًا.',

            'start_at.required' => 'يجب إدخال تاريخ ووقت بدء الحصة.',
            'start_at.date' => 'يجب أن يكون التاريخ بصيغة صحيحة.',

            'duration.required' => 'يجب إدخال مدة الحصة.',
            'duration.integer' => 'يجب أن تكون المدة رقمًا صحيحًا.',
            'duration.min' => 'يجب ألا تقل مدة الحصة عن دقيقة واحدة.',

            'password.required' => 'يجب إدخال كلمة مرور الاجتماع.',
            'password.string' => 'يجب أن تكون كلمة المرور نصية.',
            'password.max' => 'يجب ألا تزيد كلمة المرور عن 10 أحرف.',

            'start_url.required' => 'يجب إدخال رابط بدء الاجتماع.',
            'start_url.url' => 'يجب أن يكون الرابط صحيحًا.',

            'join_url.required' => 'يجب إدخال رابط الانضمام للاجتماع.',
            'join_url.url' => 'يجب أن يكون الرابط صحيحًا.',

            'meeting_id.string' => 'يجب أن يكون معرف الاجتماع نصيًا.',

            'integration.required' => 'يجب تحديد ما إذا كانت الحصة متكاملة مع Zoom.',
            'integration.boolean' => 'يجب أن تكون قيمة التكامل إما true أو false.',
        ];
    }
}