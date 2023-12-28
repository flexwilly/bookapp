<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
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
            'name'=>'required|max:200',
            'publisher'=>'required|max:50',
            'ibn'=>'required|max:50',
            'category'=>'required|max:100',
            'subcategory'=>'requred|string|max:100',
            'description'=>'required|text',
            'pages'=>'integer|max:10',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            'added_by'=>'integer|max:10'
        ];
    }
}
