<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
        return [
            'email'             => 'required|email|max:255|unique:users',
            'password'          => 'required|string|min:8|max:250|confirmed',
            'option.first_name' => 'required|string|alpha|min:3|max:20',
            'option.last_name'  => 'required|string|alpha|min:3|max:20',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'option.first_name' => __('first name'),
            'option.last_name'  => __('last name'),
        ];
    }
}
