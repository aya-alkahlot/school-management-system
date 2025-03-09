<?php

namespace App\Http\Requests\Subjects;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubject extends FormRequest
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
        'Name_Ar' => 'required|string|max:255',
        'Name_En' => 'required|string|max:255',
        'Grade_id' => 'required|exists:grades,id',
        'Classroom_id' => 'nullable|exists:classrooms,id',
        'Teacher_id' => 'required|exists:teachers,id',
    ];
}}