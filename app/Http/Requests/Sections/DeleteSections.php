<?php

namespace App\Http\Requests\Sections;

use Illuminate\Foundation\Http\FormRequest;

class DeleteSections extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * تحديد ما إذا كان المستخدم مخوّلاً لتنفيذ هذا الطلب.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * القواعد الخاصة بالتحقق من صحة الطلب.
     */
    public function rules()
    {
        return [
            'id' => 'required|exists:sections,id',
        ];
    }

    /**
     * الرسائل المخصصة للأخطاء.
     */
    public function messages()
    {
        return [
            'id.required' => 'يجب تحديد القسم لحذفه.',
            'id.exists' => 'القسم المحدد غير موجود.',
        ];
    }
}
