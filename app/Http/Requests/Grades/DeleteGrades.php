<?php

namespace App\Http\Requests\Grades;

use Illuminate\Foundation\Http\FormRequest;

class DeleteGrades extends FormRequest
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
            'id' => 'required|exists:grades,id',
        ];
    }

    /**
     * الرسائل المخصصة للأخطاء.
     */
    public function messages()
    {
        return [
            'id.required' => 'يجب تحديد المرحلة الدراسية.',
            'id.exists' => 'المرحلة الدراسية المحددة غير موجودة.',
        ];
    }
}
