<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
            'name_en'          => 'required|string|unique:roles,name_en',
            'name_ar'          => 'required|string|unique:roles,name_ar',
            'permissions'      => 'required|array|min:1',
            'permissions.*'    => 'required|integer|exists:permissions,id'
        ];
    }
}
