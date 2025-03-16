<?php

namespace App\Http\Requests\Students\AddStudents;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|min:6',
            'gender_id' => 'required|exists:genders,id',
            'nationalitie_id' => 'required|exists:nationalities,id',
            'blood_id' => 'required|exists:type_bloods,id',
            'Date_Birth' => 'required|date',
            'Grade_id' => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'parent_id' => 'required|exists:my_parents,id',
            'academic_year' => 'required|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
