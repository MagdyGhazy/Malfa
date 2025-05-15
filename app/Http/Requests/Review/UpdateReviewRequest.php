<?php

namespace App\Http\Requests\Review;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
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
            'model_id'   => 'nullable|integer',
            'model_type' => 'required|string|in:unit,room,restaurant,activity,table',
            'rate'       => 'nullable|integer|min:1|max:5',
            'message'    => 'nullable|string|max:1000',
            'images'     => 'nullable|array',
            'images.*'   => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }
}
