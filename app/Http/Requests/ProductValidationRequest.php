<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class ProductValidationRequest extends FormRequest
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
            'name' => 'required',
            'slug' => 'required|unique:products,slug',
            'category'=> 'required|exists:categories,id',
            'price' => 'required|numeric', 
            'stock' => 'required|numeric', 
            // 'images' =>'required|max:1024',
            'items.*.attribute_name' =>'sometimes|string|exists:attributes,name',
            'items.*.name' => 'required_with:items.*.attribute_name',
            'items.*.stock' => [
                'required_with:items.*.attribute_name',
                function ($attribute, $value, $fail) use ($request) {
                    // Check if the 'other_field' is present and not empty
                    if ($request->filled('items.*.attribute_name')) {
                        // If 'other_field' is present, then check if 'numeric_field' is numeric
                        if (!is_numeric($value)) {
                            // If 'numeric_field' is not numeric, add a validation error
                            $fail("The $attribute must be a number.");
                        }
                    }
                },
            ],
            'items.*.price' => [
                'required_with:items.*.attribute_name',
                function ($attribute, $value, $fail) use ($request) {
                    // Check if the 'other_field' is present and not empty
                    if ($request->filled('items.*.attribute_name')) {
                        // If 'other_field' is present, then check if 'numeric_field' is numeric
                        if (!is_numeric($value)) {
                            // If 'numeric_field' is not numeric, add a validation error
                            $fail("The $attribute must be a number.");
                        }
                    }
                },
            ],

            // 'items.*.subOptions.*.attribute_name' =>'sometimes|string|exists:attributes,name',
        ];
    }


    public function messages(): array
    {
        return [
            'name.required' => 'Please provide a name for the product',
            'slug.unique' => 'Slug cannot be generated because this slug has been already used',
            'category.required' => 'Please select category',
            'images.required' => 'Please upload at least one image.',
            'price.required' => 'Please enter a price for a product',
            'price.numeric' => 'Please provide a valid value',
            'stock.required' => 'Please enter a stock "Quantitiy" for a product',
            'stock.numeric' => 'Please enter a valid value',
            'items.*.attribute_name.exists' => 'The selected attribute name is invalid , please enter a valid value',
            'items.*.name.required_with'  => 'the name should be required in order to create this attribute',
            'items.*.price.required_with'  => 'the price should be required in order to create this attribute',
            'items.*.stock.required_with'  => 'the stock should be required in order to create this attribute',
        ];
    }
}
