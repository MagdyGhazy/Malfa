<?php

namespace App\Http\Requests\Unit;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequest extends FormRequest
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
            'user_id'         => 'nullable|exists:users,id',
            'name'            => 'nullable|string|max:255',
            'description_en'  => 'nullable|string',
            'description_ar'  => 'nullable|string',
            'type'            => 'nullable|in:1,2,3',
            'rating'          => 'nullable|integer|min:1|max:5',
            'status'          => 'nullable|in:0,1',
            'available_rooms' => 'nullable|array',
            'address.address_line_en' => 'nullable|string|max:255',
            'address.address_line_ar' => 'nullable|string|max:255',
            'address.city_id'         => 'nullable|exists:cities,id',
            'address.country_id'      => 'nullable|exists:countries,id',
            'address.lat'             => 'nullable|numeric|between:-90,90',
            'address.long'            => 'nullable|numeric|between:-180,180',
            'address.zip_code'        => 'nullable|string|max:20',
            'images'              => 'nullable|array',
            'images.*'            => 'image|mimes:jpeg,png,jpg,gif,webp|max:1042',
        ];
    }
}
