<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatingAttributeOptions;
use App\Models\Attribute;
use App\Models\AttributeOptions;
use App\Models\Product;
use App\Models\Sku;
use App\Traits\ApiResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class AttributeOptionsController extends Controller
{
    use ApiResponseTrait;
    public function store(CreatingAttributeOptions $request)
    {
        // receive product id from the edit page that the user in
        // grap the items array alongside with attribute name and loop through it grap the data then create

        if ($request->options) {
            //// Checking for Authorization
            try {
                foreach ($request->options as $single_option) {
                    $product = Product::find($single_option['product_id']);
                    $this->authorize('createing-attribute-option', $product);
                }
                // Logic for authorized post
            } catch (AuthorizationException $e) {
                // Handle the unauthorized access for this specific post
                return response()->json(['error' => 'Unauthorized Access'], 403);
            }

            // after Authorization
            try {
                DB::beginTransaction();
                foreach ($request->options as $single_option) {

                    $product = Product::find($single_option['product_id']);
                    $this->authorize('create', $product);
                    $attribute = Attribute::where('name', $single_option['attribute_name'])->first();
                    $attribute_option = $attribute->attributeOptions()->create([
                        'value' => $single_option['name'],
                    ]);

                    if ($attribute_option) {
                        $random_number = rand(0, 100000);
                        $generate_sku = $product->sku()->create([
                            'code' => 'PROD' . $random_number,
                            'price' => $single_option['price'],
                            'stock' => $single_option['stock'],
                        ]);
                        // generating sku code for every option (variant) will be created debending on the items array.
                        if ($generate_sku) {
                            $generate_sku->variant()->attach($attribute_option->id);
                        }
                    }
                }

                DB::commit();
                return $this->Success('Options/option created successfully');
            } catch (\Throwable $th) {
                DB::rollBack();
                return $this->Failed('something went wrong while creating the options', 409);
            }
        }

    }

    public function destroy($option_sku)
    {
        if ($option_sku) {
            $sku = Sku::with('product')->where('code' , $option_sku)->first();
            if ($sku) {
                $this->authorize('delete-attribute-option' , $sku);
                $is_deleted = $sku->delete();
                if ($is_deleted) {
                    return $this->Success('Sku deleted successfully');
                }else{
                    abort(503 , 'something went wrong while deleting, please try again later');
                }
                
            }else{
                abort(404 , 'Sku code not found');
            }
            
        }else{
            abort(404 , 'please provide a sku code to delete');
        }
     
    }
}