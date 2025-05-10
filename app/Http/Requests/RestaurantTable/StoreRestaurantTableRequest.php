<?php

namespace App\Http\Requests\RestaurantTable;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantTableRequest extends FormRequest
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
            'restaurant_id'   => 'required|exists:restaurants,id',
            'capacity'        => 'required|integer|min:1',
            'description_en'  => 'nullable|string',
            'description_ar'  => 'nullable|string',
            'is_available'    => 'required|boolean',
            'features'        => 'nullable|array',
            'features.*'      => 'exists:features,id',
            'images'          => 'nullable|array',
            'images.*'        => 'image|mimes:jpeg,png,jpg,gif,webp|max:1042',
        ];
    }
}
