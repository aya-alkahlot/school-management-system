<?php

namespace App\Http\Requests\Teachers\dashboard\Quizz;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizzRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // تأكد من إعطاء الصلاحية
    }

    public function rules()
    {
        return [
            'Name_en' => 'required|string|max:255',
            'Name_ar' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'Grade_id' => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
        ];
    }

    public function messages()
    {
        return [
            'Name_en.required' => 'اسم الاختبار بالإنجليزية مطلوب',
            'Name_ar.required' => 'اسم الاختبار بالعربية مطلوب',
            'subject_id.required' => 'المادة مطلوبة',
            'subject_id.exists' => 'المادة غير موجودة',
            'Grade_id.required' => 'الصف مطلوب',
            'Grade_id.exists' => 'الصف غير موجود',
            'Classroom_id.required' => 'الفصل مطلوب',
            'Classroom_id.exists' => 'الفصل غير موجود',
            'section_id.required' => 'القسم مطلوب',
            'section_id.exists' => 'القسم غير موجود',
        ];
    }
}