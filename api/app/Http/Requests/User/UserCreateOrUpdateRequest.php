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
            'name'              => 'required|max:255',
            'email'             => 'required|email|unique:users',
            'role_id'           => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required'           => 'The name field is required',
            'email.required'          => 'The email field is required.',
            'role_id.required'        => 'The role field is required.'
        ];
    }
}
