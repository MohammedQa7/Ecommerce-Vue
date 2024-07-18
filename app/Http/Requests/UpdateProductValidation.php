<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UpdateProductValidation extends FormRequest
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
        // $http_method = $this->method();
        return [
            'name' => 'required|string|max:255',
            'slug' => 'unique:products,slug,' . $this->product,
            'description' => 'nullable',
            'category' => 'required|exists:categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'options.*.sku_code' => 'required',
            'options.*.attribute_option' => 'required',
            'options.*.price' => 'required|numeric|min:0',
            'options.*.stock' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return  [
            'name.required' => 'please provide name to product',
            'category.required' => 'please provide at least one category for the product (so people can find your product faster)',
            'price.required' => 'product price is required (provide a price in case you decided to delete all attributes and variants)',
            'price.numeric' => 'please enter a valid value',
            'stock.numeric' => 'please enter a valid value',
            'options.*.sku_code.required' => 'if error accourd while editing , please contatct the support team.',
            'options.*.attribute_option.required' => 'please provide an option',
            'options.*.price.required' => 'option price is required',
            'options.*.stock.required' => 'option stock is required',
            'options.*.price.numeric' => 'please enter a valid value',
            'options.*.stock.numeric' => 'please enter a valid value',

        ];
    }
}