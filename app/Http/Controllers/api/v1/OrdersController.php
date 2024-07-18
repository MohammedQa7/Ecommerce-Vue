<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Mail\InvoiceMail;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Sku;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class OrdersController extends Controller
{
    use ApiResponseTrait;
    public $total_cart_price;
    public function index()
    {
        $all_cart_items = Cart::where('user_id', Auth::user()->id)->with(['user', 'product.images', 'options'])->get();

        if ($all_cart_items) {
            foreach ($all_cart_items as $single_cart_items) {
                $this->total_cart_price += $single_cart_items->total_price;
            }
            // Mail::to(Auth::user()->email)->send(new InvoiceMail($all_cart_items, $this->total_cart_price));
            return CartResource::collection($all_cart_items)->additional([
                'total_price' => $this->total_cart_price,
            ]);
        } else {
            return $this->Failed('Cart is empty', 404);
        }
    }

    public function indexOrder()
    {
        $order = Order::where('user_id', Auth::user()->id)->with('products' ,'variants.attribute' , 'subOptions.attribute')->get();
        if ($order) {
            return OrderResource::collection($order);
        }else{
            abort(404 , 'No Orders Were Found');
        }
    }

    public function checkout(Request $request)
    {

        $all_cart_items = Cart::where('user_id', Auth::user()->id)->with(['product.images'])->get();
        // $cached_user = Cache::add('user', Auth::user()->id, now()->addSeconds(60));
        $totalPrice = 0;
        if (sizeof($all_cart_items) > 0) {
            foreach ($all_cart_items as $single_item) {
                $totalPrice += $single_item->total_price;
            }
            Stripe::setApiKey(config('services.stripe.secret'));

            // using empped form to pay thorugh payment TOKEN
            $paymentIntent = PaymentIntent::create([
                'amount' => $totalPrice * 100,
                'currency' => 'usd',
                'payment_method' => $request->payment_token,
                'confirm' => true,
                // Confirm the payment intent immediately
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);

            if ($paymentIntent) {
                $this->EmptyCartAfterPayment();
                return $this->PaymentSuccess('Thank you! , Your order have been submitted. Go to you orderd page to see what have you orderd');
            } else {
                abort(404, 'contact the support if you are sure that your bank account has enough money');
            }

            // if we want to generate checkout token to redirect the user to stripe checkout page
            // $checkout_session = \Stripe\Checkout\Session::create([
            //     'line_items' => [
            //         [
            //             'price_data' => [
            //                 'currency' => 'USD',
            //                 'product_data' => [
            //                     'name' => 'products',
            //                 ],

            //                 // we will multiply the price by 100 to get the price format like this -> $500 , because stripe will convert the price into cents it will look like this -> $5.00
            //                 'unit_amount' => $totalPrice * 100,
            //             ],
            //             'quantity' => 1,
            //         ],
            //     ],
            //     'mode' => 'payment',
            //     'success_url' => route('success') . '?session_id={CHECKOUT_SESSION_ID}',
            //     'cancel_url' => route('cancle'),
            // ]);
            // return response()->json(['id' => $checkout_session->id]);
        } else {
            abort(404, 'Please add any items to the cart before processing to checkout page :)');
        }
        // stripe checkout payment.
    }

    public function success(Request $request)
    {
        if (Cache::has('user')) {
            $cached_user_id = Cache::get('user');
            $auth_user = Auth::loginUsingId($cached_user_id);
            if ($auth_user) {
                $all_cart_items = Cart::where('user_id', Auth::user()->id)->get();
                try {
                    // Mail::to(Auth::user()->email)->send(new InvoiceMail($all_cart_items , $this->total_cart_price));
                    foreach ($all_cart_items as $single_cart_items) {
                        DB::beginTransaction();
                        $this->total_cart_price += $single_cart_items->total_price;
                        $option = Sku::where('code', $single_cart_items->sku_code)
                            ->with(['variant'])
                            ->first();
                        $order = Order::create([
                            'user_id' => Auth::user()->id,
                            'product_id' => $single_cart_items->product_id,
                            'option_id' => $option->variant[0]->id ?? null,
                            'sub_option_id' => $single_cart_items->sub_option_id ?? null,
                            'total_price' => $single_cart_items->total_price,
                            'status' => Order::COMPLETED,
                        ]);
                        if ($order) {
                            Cart::find($single_cart_items->id)->delete();
                        }
                        DB::commit();
                    }
                    return redirect(config('app.url') . ':8000/' . 'success');
                    // return $this->PaymentSuccess('Thank you for your purchase, All details has been sent to the email that you provided');
                } catch (\Throwable $th) {
                    dd($th);
                    DB::rollBack();
                    abort(404, 'something went wrong.');
                }
            }
        } else {
            return redirect(config('app.url') . ':8000/' . '404');
        }

        // abort(200, 'Payment Has Been Succesfully charged');
    }

    public function cancle()
    {
        return redirect(config('app.url') . ':8000/' . 'checkout');
    }

    public function EmptyCartAfterPayment()
    {
        $all_cart_items = Cart::where('user_id', Auth::user()->id)->get();
        try {
            // Mail::to(Auth::user()->email)->send(new InvoiceMail($all_cart_items , $this->total_cart_price));
            foreach ($all_cart_items as $single_cart_items) {
                DB::beginTransaction();
                $this->total_cart_price += $single_cart_items->total_price;
                $option = Sku::where('code', $single_cart_items->sku_code)
                    ->with(['variant'])
                    ->first();
                $rand_order_number = rand(0, 100000000);
                $order = Order::create([
                    'order_number' => $rand_order_number,
                    'user_id' => Auth::user()->id,
                    'option_id' => $option->variant[0]->id ?? null,
                    'sub_option_id' => $single_cart_items->sub_option_id ?? null,
                    'total_price' => $single_cart_items->total_price,
                    'status' => Order::PENDING,
                ]);
                if ($order) {
                    $order->products()->attach($single_cart_items->product_id);
                    Cart::find($single_cart_items->id)->delete();
                }
                DB::commit();
            }
            // return redirect(config('app.url') . ':8000/' . 'success');
            return $this->PaymentSuccess('Thank you for your purchase, All details has been sent to the email that you provided');
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            abort(404, 'something went wrong.');
        }
    }
}