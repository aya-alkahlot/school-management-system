<?php

namespace App\Http\Requests\Students\ProcessingFees;

use Illuminate\Foundation\Http\FormRequest;

class StoreProcessingFees extends FormRequest
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
            'student_id'  => 'required|exists:students,id',
            'amount'      => 'required|numeric|min:0.01',
            'description' => 'nullable|string|max:500',
        ];
    }
}