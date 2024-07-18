<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CreatingAttributeOptions extends FormRequest
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
    public function rules(Request $request): array
    {
        return [
            'options.*.product_id' => 'required|exists:products,id',
            'options.*.attribute_name' =>'required|string|exists:attributes,name',
            'options.*.name' => 'required_with:options.*.attribute_name',
            'options.*.stock' => [
                'required_with:options.*.attribute_name',
                function ($attribute, $value, $fail) use ($request) {
                    // Check if the 'other_field' is present and not empty
                    if ($request->filled('options.*.attribute_name')) {
                        // If 'other_field' is present, then check if 'numeric_field' is numeric
                        if (!is_numeric($value)) {
                            // If 'numeric_field' is not numeric, add a validation error
                            $fail("The $attribute must be a number.");
                        }
                    }
                },
            ],
            'options.*.price' => [
                'required_with:options.*.attribute_name',
                function ($attribute, $value, $fail) use ($request) {
                    // Check if the 'other_field' is present and not empty
                    if ($request->filled('options.*.attribute_name')) {
                        // If 'other_field' is present, then check if 'numeric_field' is numeric
                        if (!is_numeric($value)) {
                            // If 'numeric_field' is not numeric, add a validation error
                            $fail("The $attribute must be a number.");
                        }
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'options.*.product_id.required' =>'Please provide the product you want to create these options for :)',
            'options.*.product_id.exists' =>'Please make sure that this product you are trying to create an option for it does exists :)',
            'options.*.attribute_name.required' => 'in order to create an option you have to provide the attribute for that option',
            'options.*.attribute_name.exists' => 'The selected attribute name is invalid , please enter a valid value',
            'options.*.name.required_with'  => 'the name should be required in order to create this option',
            'options.*.price.required_with'  => 'the price should be required in order to create this option',
            'options.*.stock.required_with'  => 'the stock should be required in order to create this option',
        ];
    }
}
