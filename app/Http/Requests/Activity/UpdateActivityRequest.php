<?php

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
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
            'user_id'                 => 'required|exists:users,id',
            'name_en'                 => 'required|string|max:255',
            'name_ar'                 => 'required|string|max:255',
            'description_en'          => 'required|string',
            'description_ar'          => 'required|string',
            'price'                   => 'required|numeric|min:0',
            'from'                    => 'required|date',
            'to'                      => 'required|date|after_or_equal:from',
            'status'                  => 'required|in:0,1',
            'features'                => 'required|array',
            'features.*'              => 'exists:features,id',
            'address.address_line_en' => 'required|string|max:255',
            'address.address_line_ar' => 'required|string|max:255',
            'address.city_id'         => 'required|exists:cities,id',
            'address.lat'             => 'required|numeric|between:-90,90',
            'address.long'            => 'required|numeric|between:-180,180',
            'address.zip_code'        => 'required|string|max:20',
            'images'                  => 'nullable|array',
            'images.*'                => 'image|mimes:jpeg,png,jpg,gif,webp|max:1042',
        ];
    }
}
