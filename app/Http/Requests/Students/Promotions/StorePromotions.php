<?php

namespace App\Http\Requests\Students\Promotions;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotions extends FormRequest
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
            'Grade_id' => 'required|exists:grades,id',
            'Classroom_id' => 'required|exists:classrooms,id',
            'section_id' => 'required|exists:sections,id',
            'academic_year' => 'required|string',

            'Grade_id_new' => 'required|exists:grades,id',
            'Classroom_id_new' => 'required|exists:classrooms,id',
            'section_id_new' => 'required|exists:sections,id',
            'academic_year_new' => 'required|string',
        ];
    }
}