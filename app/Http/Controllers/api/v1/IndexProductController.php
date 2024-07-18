<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class IndexProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('sku.variant.attribute', 'sku.variant.subOptions', 'images')->get();
        
        if ($products) {
            return ProductResource::collection($products);
        } else {
            abort(404, 'No products were found :) ');
        }
        // return ProductResource::collection(Product::with(['sku.variant' => function($query) {
        //     $query->has('attribute');
        // }])->get());
    }
}