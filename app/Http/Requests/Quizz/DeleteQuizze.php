<?php

namespace App\Http\Requests\Quizz;

use Illuminate\Foundation\Http\FormRequest;

class DeleteQuizze extends FormRequest
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
            'id' => 'required|exists:quizzes,id',
        ];
    }

    /**
     * الرسائل المخصصة للأخطاء.
     */
    public function messages()
    {
        return [
            'id.required' => 'يجب تحديد الاختبار.',
            'id.exists' => 'الاختبار المحدد غير موجود.',
        ];
    }
}
