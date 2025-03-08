<?php

namespace App\Http\Requests\Questions;

use Illuminate\Foundation\Http\FormRequest;

class DeleteQuestions extends FormRequest
{
    public function authorize()
    {
        return true; // يمكن تغييره إذا كنت تريد التحقق من الصلاحيات
    }

    /**
     * القواعد الخاصة بالتحقق من صحة الطلب.
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:questions,id',
        ];
    }

    /**
     * الرسائل المخصصة للأخطاء.
     */
    public function messages()
    {
        return [
            'id.required' => 'يجب تحديد السؤال.',
            'id.exists' => 'السؤال المحدد غير موجود.',
        ];
    }
}
