<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\KindController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\WarehouseController;
use Illuminate\Support\Facades\Route;

//use App\Http\Requests\EmailVerificationRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Public category controller routes
Route::resource('category', CategoryController::class)->only(['index', 'show']);
Route::get('parent-categories', [CategoryController::class, 'indexParentCategories']);
Route::get('/categories/products', [CategoryController::class, 'indexWithProducts']); // for the 'all' category
Route::get('/category/{category_id}/product', [CategoryController::class, 'showWithProducts']); // for a specific category

// Show product details in client
Route::resource('product', ProductController::class)->only(['show']);

// Payment methods
Route::resource('payment-method', PaymentMethodController::class)->only(['index']);

// Allow unregistered users to submit an order
Route::resource('order', OrderController::class)->only(['store']);

// Check discount code, if applicable
Route::post('/discount-code-check', [DiscountController::class, 'checkDiscountCode']);

////////////////////////////////////////////////////////////////////////
// Send email to newly registered User
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth', 'verified'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, 'init']
)->middleware(['signed'])->name('verification.verify');


Route::post('/email/verification-notification', [VerifyEmailController::class, 'resend'])
    ->middleware(['throttle:6,1'])->name('verification.send');


////////////////////////////////////////////////////////////////////////
// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user/account/profile', [UserController::class, 'showLoggedInUserInfo']);

    Route::resource('user', UserController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);

    // TODO: Upload KindImage without storing a new category is not working atm
    // TODO: Extract public routes for client website

    // Implemented route in client
    Route::resource('category', CategoryController::class)->only(['store', 'update', 'destroy']);
    Route::get('/user-authorized', [UserController::class, 'autoCompleteInputField']);

    // Not yet implemented
    Route::resource('product', ProductController::class)->except(['show']);
    Route::resource('kind', KindController::class);

    Route::resource('discount', DiscountController::class);
    Route::resource('warehouse', WarehouseController::class);
    //Route::put('/warehouse-update-product/{id}', [WarehouseController::class, 'addProductToWarehouse']);

    Route::resource('merchant', MerchantController::class);
    Route::get('/merchants/products', [MerchantController::class, 'indexWithProducts']);
    Route::get('/merchant/{merchant_id}/product', [MerchantController::class, 'showWithProducts']);

    Route::resource('cart', CartItemController::class);
    Route::get('/user-cart', [CartItemController::class, 'getCartItemsFromAuthorizedUser']);


});

//


//Route::get('/user/{uuid}/cart', [UserController::class, 'getCartItemsFromAUser']);

