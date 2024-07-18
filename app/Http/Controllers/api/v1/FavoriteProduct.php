<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class FavoriteProduct extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $user = Auth::user();
        $favorited_prodcuts = ProductResource::collection($user->favorite);
        if (sizeof($favorited_prodcuts) > 0) {
            return $favorited_prodcuts;
        } else {
            abort(404, 'No favorites were found');
        }
    }


    public function store(Request $request)
    {
        
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        if ($validated) {
            $user = Auth::user();
            $is_favorited = $user->is_favorited($request->product_id);
            if ($is_favorited) {
                return;
            } else {
                $user->favorite()->attach($request->product_id);
                return $this->Success('Product added to favorite');
            }
        }
    }

    public function destroy(Request $request, $product_id)
    {
        $product = Product::select('id' , 'user_id')->find($product_id);
        
        if ($product) {
            $user = Auth::user();
            Gate::authorize('can-unfavorite', $product);
                if ($user->is_favorited($product->id)) {
                    $user->favorite()->detach($product->id);
                    return $this->Success('Product removed from your favorite');
                }
        } else {
            abort(404, 'The selected product was not found');
        }
    }
}