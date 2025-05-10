<?php

namespace App\Http\Requests\Restaurant;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantRequest extends FormRequest
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
            'user_id'                 => 'sometimes|required|exists:users,id',
            'name'                    => 'sometimes|required|string|max:255',
            'description_en'          => 'nullable|string',
            'description_ar'          => 'nullable|string',
            'rating'                  => 'sometimes|required|integer|between:1,5',
            'opening_time'            => 'sometimes|required|date_format:H:i',
            'closing_time'            => 'sometimes|required|date_format:H:i|after:opening_time',
            'status'                  => 'required|in:1,2',
            'available_tables'        => 'nullable|array',
            'address.address_line_en' => 'sometimes|required|string|max:255',
            'address.address_line_ar' => 'sometimes|required|string|max:255',
            'address.city_id'         => 'sometimes|required|exists:cities,id',
            'address.lat'             => 'sometimes|required|numeric|between:-90,90',
            'address.long'            => 'sometimes|required|numeric|between:-180,180',
            'address.zip_code'        => 'nullable|string|max:20',
            'images'                  => 'nullable|array',
            'images.*'                => 'image|mimes:jpeg,png,jpg,gif,webp|max:1042',
            'features'                => 'nullable|array',
            'features.*'              => 'exists:features,id',
        ];
    }
}
