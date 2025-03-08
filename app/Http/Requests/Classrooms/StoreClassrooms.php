<?php

namespace App\Http\Requests\Classrooms;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassrooms extends FormRequest
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
                'List_Classes' => 'required|array',
                'List_Classes.*.Name' => 'required|string|max:255',
                'List_Classes.*.Name_class_en' => 'required|string|max:255',
                'List_Classes.*.Grade_id' => 'required|exists:grades,id',
            ];
        }
    
        /**
         * Get custom messages for validation errors.
         */
        public function messages()
        {
            return [
                'List_Classes.required' => 'يجب إدخال قائمة الفصول.',
                'List_Classes.*.Name.required' => 'يجب إدخال اسم الفصل باللغة العربية.',
                'List_Classes.*.Name_class_en.required' => 'يجب إدخال اسم الفصل باللغة الإنجليزية.',
                'List_Classes.*.Grade_id.required' => 'يجب اختيار المرحلة الدراسية.',
                'List_Classes.*.Grade_id.exists' => 'المرحلة الدراسية المحددة غير موجودة.',
            ];
        }
    }