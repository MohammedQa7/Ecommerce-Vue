<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\RatingRequestValidation;
use App\Models\Product;
use App\Models\User;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    use ApiResponseTrait;
    public function index(Request $request)
    {

    }

    public function store(RatingRequestValidation $request)
    {
        $product = Product::where('id' ,$request->product_id)->first();
        $user = Auth::user()->id;
        if ($user) {
            if ($product && !$product->isProductRatedByUser()) {
                try {
                    $product->rating()->attach($user, [
                        'rating' => $request->rating,
                        'message' => $request->message,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);

                    return $this->Success("Rating has been submitted");
                } catch (\Throwable $th) {
                    dd($th);
                    abort(404, "something went wrong while trying to submit you raitng, please try again later");
                }
            } else {
                abort(404, "the provided product was not found, or the user already rated the product");
            }
        }else{
            abort(401 , 'Please Login, To be able to rate this product');
        }
    }
}