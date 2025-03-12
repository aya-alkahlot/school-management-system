<?php

namespace App\Http\Requests\Teachers\dashboard\Student;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudent extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,' . $this->student,
            'section_id' => 'required|exists:sections,id',
            'grade_id' => 'required|exists:grades,id',
            'classroom_id' => 'required|exists:classrooms,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('validation.required'),
            'email.required' => trans('validation.required'),
            'email.email' => trans('validation.email'),
            'email.unique' => trans('validation.unique'),
            'section_id.required' => trans('validation.required'),
            'section_id.exists' => trans('validation.exists'),
            'grade_id.required' => trans('validation.required'),
            'grade_id.exists' => trans('validation.exists'),
            'classroom_id.required' => trans('validation.required'),
            'classroom_id.exists' => trans('validation.exists'),
        ];
    }
}
