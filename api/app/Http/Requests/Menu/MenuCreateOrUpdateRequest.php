<?php

namespace App\Http\Requests\Menu;

use Illuminate\Foundation\Http\FormRequest;

class MenuCreateOrUpdateRequest extends FormRequest
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
            'name'          => 'required|string|alpha_dash|unique:menus',
            'label'         => 'required|string|alpha_dash|unique:menu_items',
            'role_id'       => 'required',
            'permission_id' => 'required',
            'route'         => 'required',
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
            'name.required'     => 'The name field is required.',
            'name.alpha_dash'   => 'The name may only contain letters, numbers, dashes, and underscores.',
            'name.unique'       => 'The name is already taken.',
            'label.required'    => 'The label field is required.',
            'label.alpha_dash'  => 'The label may only contain letters, numbers, dashes, and underscores.',
            'label.unique'      => 'The label is already taken.',
            'route.required'    => 'The route field is required.',
        ];
    }
}
