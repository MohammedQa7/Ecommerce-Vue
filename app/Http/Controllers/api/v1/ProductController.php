<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductValidationRequest;
use App\Http\Requests\UpdateProductValidation;
use App\Http\Resources\ProductResource;
use App\Models\Attribute;
use App\Models\AttributeOptions;
use App\Models\Product;
use App\Models\Sku;
use App\Traits\ApiResponseTrait;
use Carbon\Doctrine\DateTimeDefaultPrecision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use ApiResponseTrait;
    public function store(ProductValidationRequest $request)
    {

        try {
            // creating product information
            DB::beginTransaction();
            $product = Product::create([
                'name' => $request->name,
                'slug' => $request->slug,
                'description' => $request->description,
                'user_id' => 1,
                'category_id' => 1
            ]);


            // // checking if the product has been successfully created.
            if ($product) {
                // assigning product images to another table
                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $single_image) {
                        $image_path = $single_image->store('products/images', 'public');
                        $image_url = Storage::url($image_path);
                        $product->images()->create([
                            'image_path' => $image_url
                        ]);
                    }
                }

                // generating SKU if there is Attribute Value
                if ($request->items) {
                    foreach ($request->items as $single_item) {
                        $attribute = Attribute::where('name', $single_item['attribute_name'])->first();
                        $attribute_option = $attribute->attributeOptions()->create([
                            'value' => $single_item['name'],
                        ]);

                        if ($attribute_option) {
                            $random_number = rand(0, 100000);
                            $generate_sku = $product->sku()->create([
                                'code' => 'PROD' . $random_number,
                                'price' => $single_item['price'],
                                'stock' => $single_item['stock'],
                            ]);

                            if ($generate_sku) {
                                $generate_sku->variant()->attach($attribute_option->id);
                            }
                        }
                    }
                } else {
                    // generating SKU if there is no "Attribute Value"
                    $this->GenerateDefaultSKU($request, $product);
                }

                // this will 100% be called after the creating a product , it has no control of what happen after the product creataion.
                DB::commit();
                return $this->Success('Product created Successfully');

            } else {
                return $this->Failed('Something went wrong, please try again later', 400);
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->Failed('Something went wrong, please try again later', 400);
        }

    }

    public function show($slug)
    {

        $single_product = Product::where('slug', $slug)->with(
            [
                'rating' => function ($query) {
                    $query->orderBy('pivot_created_at', 'desc');
                },
                'category',
                'images',
                'sku.variant.attribute',
                'sku.variant.subOptions'
            ],

        )->first();
        $grouped_rating = $single_product->rating->groupBy('pivot.rating')->toArray();
        $total_rating = count($single_product->rating); // 5

        $result = [];
        $percentage_rate = 0;
        $ratings = [5, 4, 3, 2, 1];

        // initiate empty array with kays and values 
        foreach ($ratings as $rating) {
            $result[$rating] = [
                'key' => $rating,
                'percentage' => 0.0,
                'countRating' => 0
            ];
        }

        // update the initiated array with the new keys and value.
        foreach ($grouped_rating as $key => $rating_array) {
            $key_total_rating = count($rating_array);
            $percentage_rate = ($key_total_rating / $total_rating) * 100;
            $result[$key] = [
                'key' => $key,
                'percentage' => $percentage_rate,
                'countRating' => $key_total_rating
            ];
            $percentage_rate = 0;
        }

        $single_product->percentageRating = $result;



        // if ($single_product) {
        //     $grouped_variants = collect($single_product->sku->flatMap(function ($sku) {
        //         return [
        //             'sku_code' => $sku->code,
        //             'price' => $sku->price,
        //             'stock' => $sku->stock,
        //             'variant' => $sku->variant,
        //         ];
        //     }))->groupBy(function ($variant) {
        //         // dump($variant);
        //         // return $variant->attribute->name;
        //     });
        // }
        // dd($grouped_variants->toArray());
        // $productDetails = [
        //     'grouped_variants' => []
        // ];
        // foreach ($single_product->sku as $single_sku) {
        //     if (sizeof($single_sku->variant) > 0) {
        //         foreach ($single_sku->variant as $single_variant) {
        //             $productDetails['grouped_variants'][$single_variant->attribute->name][] = [
        //                 'option_id' => $single_variant->id,
        //                 'option_value' => $single_variant->value,
        //             ];
        //         }
        //     }
        // }

        // dd($single_product->toArray());
        // $single_product = Product::where('slug' , $slug)->with(['sku' => function($query) {
        //     //check if sku has the variant relation in it.
        //     $query->whereHas('variant' , function($query){
        //         // check if variant has the subOptions relation in it then display the sku.variant depending on the result from the whereHas('attribute').
        //     });
        // } , 'sku.variant' , 'sku.variant.attribute','sku.variant.subOptions'])->first();
        // dd($single_product->toArray());
        // dd($productDetails);
        if ($single_product) {
            return new ProductResource($single_product);
        } else {
            abort(404, 'Product not found');
            // return $this->Failed('Product not found', 404);
        }
    }

    public function edit($slug)
    {
        $product = Product::where('slug', $slug)->with('category', 'sku.variant.attribute', 'sku.variant.subOptions.attribute')->first();
        return new ProductResource($product);
    }

    public function update(UpdateProductValidation $request, $id)
    {
        // $product = Product::where('slug' , $slug)->with('category', 'sku.variant.attribute','sku.variant.subOptions.attribute')->first();
        $product = Product::with('sku.variant.attribute', 'sku.variant.subOptions.attribute')->find($id);
        if ($product) {
            $this->authorize('update', $product);
            $product->update($request->only([
                'name',
                'description',
                'slug',
                'category'
            ]));
            // making sure that there is DEFAULT SKU
            $default_sku = $product->sku()->get();
            foreach ($default_sku as $single_default_sku) {
                if (str_contains($single_default_sku->code, 'DEFAULT')) {
                    $sku = $product->sku()->where('code', $single_default_sku->code);
                    $sku->update([
                        'price' => $request->price,
                        'stock' => $request->stock,
                    ]);
                }
            }
            // updating product option if founded.
            $attribute_items = $request->options;
            if ($attribute_items) {
                foreach ($attribute_items as $single_item) {
                    if ($product->sku()) {
                        $sku = $product->sku()->where('code', $single_item['sku_code'])->first();
                        if ($sku) {
                            $sku->update([
                                'price' => $single_item['price'],
                                'stock' => $single_item['stock'],
                            ]);
                            if ($sku->variant()) {
                                $sku->variant()->update([
                                    'value' => $single_item['attribute_option'],
                                ]);
                            }
                        }
                    }

                }
            }
            // updating product sub options if founded.
            $subOptions_items = $request->subOptions;
            if ($subOptions_items) {
                foreach ($subOptions_items as $single_option) {
                    // getting the option that the user provide to check if there was a option before to update it 
                    $option = AttributeOptions::with('attribute')->find($single_option['sub_option_id']);
                    $attribute = Attribute::where('name', $single_option['attribute_name'])->first();
                    dd($attribute);
                    // getting the pivot table data to update the price and stock 
                    $sub_option = $option->childSubOptions()->first();

                    // updating the option name and attribute id if it was changed
                    if ($option && $attribute) {
                        $option->update([
                            'value' => $single_option['sub_option_name'],
                            'attribute_id' => $attribute->id
                        ]);
                    }

                    // updating the price and stock in the many to many relationship of AttributeOptions and SubOptions (attribute_option_sub)
                    if ($sub_option) {
                        $sub_option->pivot->update([
                            'price' => $single_option['price'],
                            'stock' => $single_option['stock'],
                        ]);
                    }

                }
            }
            return $this->Success('Changes has been saved!');

        } else {
            return $this->Failed('Product not found', 404);
        }

        // dd($product->sku()->where('code' , 'PROD57171')->first());
    }


    public function GenerateDefaultSKU(Request $request, $product)
    {
        $string = 'ZXCVBNMASDFGHJKLQWERTYUIOPzxcvbnmasdfghjklqwertyuiop';
        $random_string = substr(str_shuffle($string), 0, 5);
        $random_number = rand(0, 10000);
        $product->sku()->create([
            'code' => 'PROD' . $random_number . $random_string . '-' . 'DEFAULT',
            'price' => $request->price,
            'stock' => $request->stock,
        ]);
    }

}