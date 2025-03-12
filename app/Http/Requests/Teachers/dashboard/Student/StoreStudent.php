<?php

namespace App\Http\Requests\Teachers\dashboard\Student;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudent extends FormRequest
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
            'students.*.name' => 'required|string|max:255',
            'students.*.email' => 'required|email|unique:students,email',
            'students.*.section_id' => 'required|exists:sections,id',
            'students.*.grade_id' => 'required|exists:grades,id',
            'students.*.classroom_id' => 'required|exists:classrooms,id',
        ];
    }

    public function messages()
    {
        return [
            'students.*.name.required' => trans('validation.required'),
            'students.*.email.required' => trans('validation.required'),
            'students.*.email.email' => trans('validation.email'),
            'students.*.email.unique' => trans('validation.unique'),
            'students.*.section_id.required' => trans('validation.required'),
            'students.*.section_id.exists' => trans('validation.exists'),
            'students.*.grade_id.required' => trans('validation.required'),
            'students.*.grade_id.exists' => trans('validation.exists'),
            'students.*.classroom_id.required' => trans('validation.required'),
            'students.*.classroom_id.exists' => trans('validation.exists'),
        ];
    }
}