<?php

namespace App\Http\Requests\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoleRequest extends FormRequest
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
        $id = $this->route('id');

        return [
            'name_en'          => ['required', 'string', 'max:255', Rule::unique('roles', 'name_en')->ignore($id),],
            'name_ar'          => ['required', 'string', 'max:255', Rule::unique('roles', 'name_ar')->ignore($id),],
            'permissions'      => 'required|array|min:1',
            'permissions.*'    => 'required|integer|exists:permissions,id'
        ];
    }
}
