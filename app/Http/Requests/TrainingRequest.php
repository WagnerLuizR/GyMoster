<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TrainingRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'difficult_level' => 'required|in:i,in,a',
            'duration' => 'required',
            'type' => 'required|in:a,c,m,tf,tfx,tai,tc,tm',
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
            'name' => 'Campo :attribute obrigatório.',
            'difficult_level' => 'Campo :attribute obrigatório.',
            'duration' => 'Campo :attribute obrigatório.',
            'type' => 'Campo :attribute obrigatório.'
        ];
    }
}
