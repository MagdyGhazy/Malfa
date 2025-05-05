<?php

namespace App\Http\Requests\Unit;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequest extends FormRequest
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
            'user_id'         => 'required|exists:users,id',
            'name'            => 'required|string|max:255',
            'description_en'  => 'nullable|string',
            'description_ar'  => 'nullable|string',
            'type'            => 'required|in:1,2,3',
            'rating'          => 'required|integer|min:1|max:5',
            'status'          => 'required|in:0,1',
            'available_rooms' => 'required|array',
            'address.address_line_en' => 'required|string|max:255',
            'address.address_line_ar' => 'required|string|max:255',
            'address.city_id'         => 'required|exists:cities,id',
            'address.lat'             => 'required|numeric|between:-90,90',
            'address.long'            => 'required|numeric|between:-180,180',
            'address.zip_code'        => 'nullable|string|max:20',
            'images'              => 'nullable|array',
            'images.*'            => 'image|mimes:jpeg,png,jpg,gif,webp|max:1042',

        ];
    }
}
