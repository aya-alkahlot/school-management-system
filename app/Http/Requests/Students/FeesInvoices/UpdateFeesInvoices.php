<?php

namespace App\Http\Requests\Students\FeesInvoices;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFeesInvoices extends FormRequest
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
            'title.en' => 'sometimes|required|string|max:255', 
            'title.ar' => 'sometimes|required|string|max:255|regex:/^[\p{Arabic}\s]+$/u',
            'amount' => 'sometimes|required|numeric|min:0', 
            'Grade_id' => 'sometimes|required|exists:grades,id', 
            'Classroom_id' => 'sometimes|required|exists:classrooms,id', 
            'year' => 'sometimes|required|digits:4', 
            'description' => 'nullable|string', 
            'Fee_type' => 'sometimes|required|integer|in:1,2', 
            'student_id' => 'sometimes|required|exists:students,id', 
            'fee_id' => 'sometimes|required|exists:fees,id', 
        ];
    }
}