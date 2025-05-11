<?php

namespace App\Http\Requests\RestaurantTable;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantTableRequest extends FormRequest
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
            'restaurant_id'   => 'sometimes|exists:restaurants,id',
            'capacity'        => 'sometimes|integer|min:1',
            'description_en'  => 'nullable|string',
            'description_ar'  => 'nullable|string',
            'is_available'    => 'sometimes|boolean',
            'features'        => 'nullable|array',
            'features.*'      => 'exists:features,id',
            'images'          => 'nullable|array',
            'images.*'        => 'image|mimes:jpeg,png,jpg,gif,webp|max:1042',
        ];
    }
}
