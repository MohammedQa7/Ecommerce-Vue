<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequestValidation extends FormRequest
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
            'product_id' => 'required|exists:products,id',
            'rating' => 'min:1|max:5',
            'message' => 'nullable|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'product_id.required' => 'Please provide a product to be able to apply your rating',
            'product_id.exists' => 'Please provide a valid product :) ',
            'rating.min' => 'the rating should be at least 1',
            'rating.max' => 'the rating should be at most 5',
            'message.max' => 'message should be less than 255 characters'
        ];
    }
}