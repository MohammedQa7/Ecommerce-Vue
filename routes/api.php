<?php

use App\Http\Controllers\api\v1\AddToCartController;
use App\Http\Controllers\api\v1\AttributeController;
use App\Http\Controllers\api\v1\AttributeOptionsController;
use App\Http\Controllers\api\v1\auth\ForgetPasswordController;
use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\api\v1\CartController;
use App\Http\Controllers\api\v1\FavoriteProduct;
use App\Http\Controllers\api\v1\IndexProductController;
use App\Http\Controllers\api\v1\OrdersController;
use App\Http\Controllers\api\v1\ProductController;
use App\Http\Controllers\api\v1\RatingController;
use App\Http\Controllers\api\v1\SubOptionsController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $current_user = $request->user();
    if ($current_user) {
        return new UserResource($current_user);
    }
});

Route::group(['prefix' => 'v1'], function () {
    // LOGIN Endpoints
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::middleware('guest')->group(function () {
        Route::post('forgot-password', [ForgetPasswordController::class, 'RequestPasswordLink'])->name('password.email.auth');
        // the reset route will be in the web.php route because laravel expect from us that there is a route called reset-password/{token} that will be directed to.
        Route::post('reset-password', [ForgetPasswordController::class, 'resetPassword'])->name('password.update.auth');
    });

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
    });

    // After payment endpoins
    Route::get('success', [OrdersController::class, 'success'])->name('success');
    Route::get('cancle', [OrdersController::class, 'cancle'])->name('cancle');

    Route::get('products', [IndexProductController::class, 'index']);
    Route::resource('product', ProductController::class, ['except' => ['index']]);
    Route::resource('attribute', AttributeController::class);
    Route::resource('attribute/options', AttributeOptionsController::class);
    Route::resource('attribute/sub/option', SubOptionsController::class, ['except' => ['destroy']]);
    Route::delete('attribute/sub/option/{parentOptionId}/{subOptionId}/delete', [SubOptionsController::class, 'destroy']);

    //Rating a product
    Route::resource('/rate' , RatingController::class);

    //Add to cart
    Route::resource('add-to-cart', CartController::class);
    // Checkout page
    Route::get('checkout', [OrdersController::class, 'index'])->middleware('auth:sanctum');
    Route::get('orders', [OrdersController::class, 'indexOrder']);
    Route::post('checkout', [OrdersController::class, 'checkout']);

    // product favorite
    Route::resource('favorite', FavoriteProduct::class, ['except' => ['show']])->middleware('auth:sanctum');
    Route::middleware('auth:sanctum')->group(function () {
        // Route::resource('product' , ProductController::class,['except'=> ['index']]);
        // Route::post('logout' , [AuthenticatedSessionController::class , 'destroy']);
    });
});