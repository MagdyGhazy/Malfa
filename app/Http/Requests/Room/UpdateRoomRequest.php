<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'unit_id'           => 'nullable|exists:units,id',
            'room_type'         => 'nullable|in:1,2,3,4,5,6',
            'price_per_night'   => 'nullable|numeric|min:0',
            'capacity'          => 'nullable|integer|min:1',
            'description_en'    => 'nullable|string',
            'description_ar'    => 'nullable|string',
            'rules_en'          => 'nullable|string',
            'rules_ar'          => 'nullable|string',
            'is_available'      => 'nullable|in:1,2',
            'images'            => 'nullable|array',
            'images.*'          => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];
    }
}
