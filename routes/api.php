<?php

use App\Http\Controllers\Admin\CategoryAdminController;
use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\OrderAdminController;
use App\Http\Controllers\Admin\OrderStatusAdminController;
use App\Http\Controllers\Admin\PaymentDetailsAdminController;
use App\Http\Controllers\Admin\ProductAdminController;
use App\Http\Controllers\Admin\UserAdminController;
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
use App\Http\Middleware\EnsureAdminRole;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;


use Illuminate\Http\Request;

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

// Front page products
Route::get('/product/show-front-page/{id}', [ProductController::class, 'showProductFrontPage']);
Route::get('/product/show-products-front-page', [ProductController::class, 'indexProductsFrontPage']);


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

// Password reset
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => $password
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');


////////////////////////////////////////////////////////////////////////
// Protected Routes
Route::group(['middleware' => ['auth:sanctum', 'ability:admin,moderator,customer']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user/account/profile', [UserController::class, 'showLoggedInUserInfo']);

    Route::get('/user-is-admin', [AuthController::class, 'checkAdmin']);

    Route::resource('user', UserController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);

    // TODO: Upload KindImage without storing a new category is not working atm
    // TODO: Extract public routes for client website

    ///////////////////////////////////////////////////
    // Implemented route in client

    // Category
    Route::resource('category', CategoryController::class)->only(['store', 'update', 'destroy']);

    // User
    Route::get('/user-authorized', [UserController::class, 'autoCompleteInputField']);
    Route::patch('/user-update-info', [UserController::class, 'updateLoggedInUserInfo']);
    Route::post('/user-update-avatar', [UserController::class, 'updateAvatar']);
    Route::patch('/user-change-password', [UserController::class, 'changePassword']);

    // Orders
    Route::resource('order', OrderController::class)->except(['store']);
    Route::get('/order/pagination/{currentPage}', [OrderController::class, 'indexForLoggedInUser']);
    Route::get('/order/{orderStatusId}/pagination/{currentPage}', [OrderController::class, 'indexForLoggedInUserBasedToOrderStatus']);

    ////////////////////////////////////////////////////
    // Not yet implemented
    Route::resource('product', ProductController::class)->except(['show']);
    Route::resource('kind', KindController::class);

    Route::resource('discount', DiscountController::class);


    Route::resource('cart', CartItemController::class);
    Route::get('/user-cart', [CartItemController::class, 'getCartItemsFromAuthorizedUser']);
});

/////////////////////////////////////////////////////////
// ADMIN ROUTES
Route::prefix('admin')->group(function () {
    Route::group(['middleware' => ['auth:sanctum', 'ability:admin,moderator']], function () {
//    Route::get('/admin', [DashboardAdminController::class, 'index']);

        /////////////////////////////////////////////////////////
        // PRODUCTS
//        Route::resource('product', ProductAdminController::class);
        Route::get('product', [ProductAdminController::class, 'index']);
        Route::post('product', [ProductAdminController::class, 'store']);
        Route::get('product/{id}', [ProductAdminController::class, 'show']);
        Route::post('product/{id}', [ProductAdminController::class, 'updateProductWithFileUpload']);
        Route::get('product-to-trash/{id}', [ProductAdminController::class, 'moveItemToTrash']);
        Route::get('product-trash', [ProductAdminController::class, 'itemsInTrashIndex']);
        Route::get('product-trash-restore/{id}', [ProductAdminController::class, 'restoreItem']);
        Route::delete('product/{id}', [ProductAdminController::class, 'destroy']);

        // Add image for product, for client's product details page operations
        Route::get('product-details', [ProductAdminController::class, 'productIndexForImage']);
        Route::get('product-details/{productId}/models', [ProductAdminController::class, 'modelIndexForImage']);
        Route::post('product-details/models/image-upload',
            [ProductAdminController::class, 'uploadImagesForModel']);

        /////////////////////////////////////////////////////////
        // CATEGORIES
//        Route::resource('category', CategoryAdminController::class);
        Route::get('category', [CategoryAdminController::class, 'index']);
        Route::post('category', [CategoryAdminController::class, 'store']);
        Route::get('category/{id}', [CategoryAdminController::class, 'show']);
        Route::post('category/{id}', [CategoryAdminController::class, 'update']);
        Route::delete('category/{id}', [CategoryAdminController::class, 'destroy']);

        Route::resource('warehouse', WarehouseController::class); // TODO: CHANGE TO ADMIN
        //Route::put('/warehouse-update-product/{id}', [WarehouseController::class, 'addProductToWarehouse']);

        /////////////////////////////////////////////////////////
        // ORDERS
        Route::resource('order', OrderAdminController::class);
        Route::patch('order-status-update/{uuid}', [OrderAdminController::class, 'updateOrderStatus']);
//        Route::post('order/{id}', [OrderAdminController::class, 'update']);

        // Order Statuses
        Route::get('order-status', [OrderStatusAdminController::class, 'getOrderStatus']);


        /////////////////////////////////////////////////////////
        // PAYMENT DETAILS
        Route::resource('payment-details', PaymentDetailsAdminController::class);

        Route::resource('merchant', MerchantController::class);
        Route::get('/merchants/products', [MerchantController::class, 'indexWithProducts']);
        Route::get('/merchant/{merchant_id}/product', [MerchantController::class, 'showWithProducts']);


//    Route::get('/admin/user-authorized', [UserAdminController::class, 'showLoggedInUserInfo']);
    });
});



