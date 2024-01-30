<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationPostRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username'  => 'required|string|alpha_dash|unique:users',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|string|min:8|max:255|confirmed',
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'username.required'     => 'The username field is required.',
            'username.alpha_dash'   => 'The username may only contain letters, numbers, dashes, and underscores.',
            'username.unique'       => 'The username is already taken.',
            'email.required'        => 'The email field is required.',
            'email.email'           => 'Please enter a valid email address.',
            'email.unique'          => 'The email address is already in use.',
            'password.required'     => 'The password field is required.',
            'password.min'          => 'The password must be at least 8 characters.',
            'password.max'          => 'The password may not be greater than 255 characters.',
            'password.confirmed'    => 'The password confirmation does not match.',
        ];
    }
}
