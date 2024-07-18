<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarValidationRequest;
use App\Http\Resources\CartResource;
use App\Mail\InvoiceMail;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Sku;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        // $all_cart_items = Cart::with(['product.images', 'options'])->where('user_id', Auth::user()->id ?? 1)->get();
        $all_cart_items = Cart::where('user_id', Auth::user()->id ?? null)->with(['product.images'])->get();
        // dd($all_cart_items->toArray());
        if (sizeof($all_cart_items) > 0) {
            return CartResource::collection($all_cart_items)->additional(['cartCount' => count($all_cart_items)]);
        } else {
            abort(404, 'Cart is empty');
        }
    }

    // stroing all the details .
    public function store(CarValidationRequest $request)
    {
        // $this->authorize('create', Cart::class);
        $product = Product::with([
            'sku' => function ($query) use ($request) {
                $query->where('code', $request->sku_code);
            },
            'sku.variant.subOptions' => function ($query) use ($request) {
                $query->where('id', $request->sub_option);
            },
            'sku.variant.subOptions'
        ])->find($request->product_id);

        // Simplify the structure by converting single-element arrays to objects
        // $single_product = json_decode(json_encode($product->sku));
        // $single_sku = $this->simplifyObject($single_product);

        if ($product && sizeof($product->sku) > 0) {
            //  product has sku and the sku has variant and the variant has sub options
            if (isset($product->sku[0]->variant) && sizeof($product->sku[0]->variant) > 0) {
                if (sizeof($product->sku[0]->variant[0]->subOptions) > 0) {
                    if ($product->sku[0]->variant[0]->subOptions[0]->pivot->stock > 0 && $product->sku[0]->variant[0]->subOptions[0]->pivot->stock >= $request->quantity) {
                        try {
                            //in Stock
                            DB::beginTransaction();
                            $total_price = $request->quantity * $product->sku[0]->variant[0]->subOptions[0]->pivot->price;
                            $this->CreateCartItem($request, $total_price);
                            $product->sku[0]->variant[0]->subOptions[0]->pivot->update([
                                'stock' => $product->sku[0]->variant[0]->subOptions[0]->pivot->stock - $request->quantity
                            ]);
                            DB::commit();
                            return $this->Success('item added to cart');
                        } catch (\Throwable $th) {
                            DB::rollBack();
                            abort(400, 'something went wrong, please try again later, if you are not loggen in , please login and try again');
                        }
                    } else {
                        // Not in Stock
                        abort(409, 'out of stock');
                    }
                } else {
                    if ($product->sku[0]->stock > 0 && $product->sku[0]->stock >= $request->quantity) {
                        //in Stock
                        try {
                            DB::beginTransaction();
                            $total_price = $request->quantity * $product->sku[0]->price;
                            $this->CreateCartItem($request, $total_price);
                            $product->sku[0]->update([
                                'stock' => $product->sku[0]->stock - $request->quantity
                            ]);
                            DB::commit();
                            return $this->Success('item added to cart');
                        } catch (\Throwable $th) {
                            DB::rollBack();
                            abort(400, 'something went wrong, please try again later, if you are not loggen in , please login and try again');
                        }
                    } else {
                        // Not in Stock
                        abort(409, 'out of stock');
                    }
                }
            } else {
                // variant has no sub option && maybe the sku code has no variant ... it does not matter of the sku has vairant or not actually

                if ($product->sku[0]->stock > 0 && $product->sku[0]->stock >= $request->quantity) {
                    //in Stock
                    try {
                        DB::beginTransaction();
                        $total_price = $request->quantity * $product->sku[0]->price;
                        $this->CreateCartItem($request, $total_price);
                        $product->sku[0]->update([
                            'stock' => $product->sku[0]->stock - $request->quantity
                        ]);
                        DB::commit();
                        return $this->Success('item added to cart');
                    } catch (\Throwable $th) {
                        DB::rollBack();
                        abort(400, 'something went wrong, please try again later');
                    }
                } else {
                    // Not in Stock
                    abort(409, 'out of stock');
                }
            }
        } else {
            // product has no sku code
            // temp solution
            abort(400, 'something went wrong , product has no sku code , please contact the support or the seller');
        }
    }

    public function update()
    {

    }

    public function destroy($id)
    {
        if ($id) {
            $cart = Cart::find($id);
            if (!is_null($cart)) {
                $this->authorize('delete', $cart);
                $cart->delete();
                return $this->Success('Item has been removed');
            } else {
                abort(404, 'Item not found in cart');
            }
        }
    }




    public function CreateCartItem(Request $request, $total_price)
    {
        $cart = Cart::UpdateOrCreate(['sku_code' => $request->sku_code , 'sub_option_id' => $request->sub_option , 'user_id' => Auth::user()->id], [
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
        ]);
    }
    function simplifyObject($obj)
    {
        if (is_array($obj) && count($obj) === 1) {
            return $this->simplifyObject($obj[0]);
        }
        if (is_object($obj) || is_array($obj)) {
            foreach ($obj as $key => $value) {
                $obj->$key = $this->simplifyObject($value);
            }
        }
        return $obj;
    }

}