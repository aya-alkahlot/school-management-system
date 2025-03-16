<?php

namespace App\Http\Requests\Students\dashboard\Profiles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfiles extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $this->route('id'),
            'phone' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:6',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحاً',
            'email.unique' => 'البريد الإلكتروني مستخدم بالفعل',
            'password.min' => 'كلمة المرور يجب أن تكون على الأقل 6 أحرف',
        ];
    }
}