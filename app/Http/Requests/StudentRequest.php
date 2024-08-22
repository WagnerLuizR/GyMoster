<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nickname' => 'required|min:4|max:255',
            'age' => 'required|integer',
            'gender' => 'required',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'bmi' => 'nullable|numeric',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'nickname' => 'Campo :attribute obrigatório.',
            'age' => 'Campo :attribute obrigatório.',
            'gender' => 'Campo :attribute obrigatório.',
            'height' => 'Campo :attribute obrigatório.',
            'weight' => 'Campo :attribute obrigatório.',
            'bmi' => 'Campo :attribute obrigatório.',
        ];
    }
}
