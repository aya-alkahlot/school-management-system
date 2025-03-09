<?php

namespace App\Http\Requests\Subjects;

use Illuminate\Foundation\Http\FormRequest;

class DeleteSubject extends FormRequest
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
            'id' => 'required|exists:subjects,id',
        ];
    }
}