<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $id = $this->route('id');

        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                Rule::unique('categories', 'name')->ignore($id),

            ],
            'description' => [
                'nullable',
                'min:5',
                'filter:laravel,php',
            ],
            'parent_id' => [
                'nullable',
                'exists:categories,id'
            ],
            'image' => [
                'nullable',
                'image',
                'mimes:jpg,png,jpeg,gif,svg',
                'max:1048576',
                'dimensions:min_width=100,min_height=100'
            ],
            'status' => [
                'required',
                'in:active,inactive',
            ],

        ];
    }

    // custom message

    public function messages()
    {
        return [
            'name.required' => 'Required!!',
        ];
    }
}
