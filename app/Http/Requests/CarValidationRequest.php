<?php

namespace App\Http\Requests;

use App\Models\Sku;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CarValidationRequest extends FormRequest
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
            'product_id' => 'required |exists:products,id',
            'sku_code' => 'required|exists:skus,code',
            'quantity' => 'required | min:1 | numeric',
            'sub_option' => [
                'nullable',
                function ($attribute, $value, $fail) use ($request) {
                    // Check if the 'other_field' is present and not empty
                    if ($request->filled('sub_option')) {
                        // If 'other_field' is present, then check if 'numeric_field' is numeric
                        $sku = Sku::with('variant.subOptions')->where('code', $request->sku_code)->first(); // Use first() to retrieve a single SKU
                        
                        if (isset($sku->variant)) {
                            $parant_attribute = $sku->variant[0];
                            $subOption = $parant_attribute->SubOptions->where('id', $request->sub_option)->first();
                            if (empty($subOption)) {
                                $fail('please choose a valid sub option.');
                            }
                        }else{
                            $fail('do not provide sub option, because this sku has no variants');
                        }
                    }
                },
            ],
        ];
    }

    // makeing sure that the required validation accours even when there is no attribute in the request
    public function withValidator($validator)
    {
        $validator->sometimes('sub_option', 'required', function ($input) {
            // Check if both variant and subvariant relationships exist
            $sku = Sku::with('variant.subOptions')->where('code', $input->sku_code)->first(); // Use first() to retrieve a single SKU
            if ($sku) {
                if (sizeof($sku->variant) > 0 ) {
                    if (sizeof($sku->variant[0]->subOptions) > 0) {
                        return $sku->variant && $sku->variant[0]->subOptions;
                    }
                }
                return false;
            }
        });
    }
    // public function withValidator($validator)
    // {
    //     $validator->sometimes('sub_option_id', 'required', function ($request) use($validator){
    //         $sku = Sku::with('variant.subOptions')->where('code', $request->sku_code)->first(); // Use first() to retrieve a single SKU
    //         // Check if SKU exists and if it has a variant with data in it
    //         if (!$sku) {
    //             return false;
    //         }
    //         if ($sku->variant && !empty($sku->variant[0]->subOptions)) {
    //             if ($request->filled('sub_option_id')) {
    //                 $parant_attribute = $sku->variant[0];
    //                 $subOption = $parant_attribute->SubOptions->where('id' , $request->sub_option_id)->first();

    //                 if (empty($subOption)) {
    //                     $validator->errors()->add('sub_option_id', 'The selected sub option is not valid.');

    //                     return true; // Validation failed
    //                 }
    //             }
    //         }

    //         return false;
    //     });

    //     return $validator;
    // }

    public function messages(): array
    {
        return [
            'user_id.required' => 'Please provide a user',
            'product_id.required' => 'Please provide the product that you need to add to cart',
            'sku_code.required' => 'Please choose at least one variant',
            'sub_option.required' => 'The sub option field is required along with the variant option',
        ];
    }
}