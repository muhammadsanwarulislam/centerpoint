<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateOrUpdateRequest extends FormRequest
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
            'role_id'   => 'required',
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
            'role_id.required'      => 'The role field is required.',
        ];
    }
}
