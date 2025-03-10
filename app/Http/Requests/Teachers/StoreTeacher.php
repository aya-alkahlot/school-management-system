<?php

namespace App\Http\Requests\Teachers;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeacher extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * قواعد التحقق من صحة البيانات.
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required|string|min:6|confirmed',
            'Name_en' => 'required|string|max:255',
            'Name_ar' => 'required|string|max:255',
            'Specialization_id' => 'required|exists:specializations,id',
            'Gender_id' => 'required|exists:genders,id',
            'Joining_Date' => 'required|date',
            'Address' => 'nullable|string|max:500',
        ];
    }

    /**
     * تخصيص رسائل الخطأ.
     */
    public function messages()
    {
        return [
            'email.required' => 'البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب إدخال بريد إلكتروني صالح.',
            'email.unique' => 'هذا البريد الإلكتروني مستخدم بالفعل.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'يجب أن تكون كلمة المرور 6 أحرف على الأقل.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'Name_en.required' => 'اسم المعلم باللغة الإنجليزية مطلوب.',
            'Name_ar.required' => 'اسم المعلم باللغة العربية مطلوب.',
            'Specialization_id.required' => 'التخصص مطلوب.',
            'Specialization_id.exists' => 'التخصص غير موجود.',
            'Gender_id.required' => 'الجنس مطلوب.',
            'Gender_id.exists' => 'الجنس غير موجود.',
            'Joining_Date.required' => 'تاريخ الانضمام مطلوب.',
            'Joining_Date.date' => 'يجب أن يكون تاريخًا صالحًا.',
            'Address.max' => 'العنوان لا يجب أن يتجاوز 500 حرف.',
        ];
    }
}
