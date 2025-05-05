<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddressRequest extends FormRequest
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
            'model_type'       => 'nullable', 'string',
            'model_id'         => 'nullable', 'integer',
            'address_line_en' => 'nullable|string|max:255',
            'address_line_ar' => 'nullable|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'lat' => 'nullable|numeric|between:-90,90',
            'long' => 'nullable|numeric|between:-180,180',
            'city_id' => 'nullable|exists:cities,id',
        ];
    }
}
