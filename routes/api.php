<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


////////////////////////////////////////////////////////////////////////
// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/login', ['as' => 'login', 'uses' => 'App\Http\Controllers\AuthController@logInPage']);
//Route::get('login', [AuthController::class, 'loginPage']);

////////////////////////////////////////////////////////////////////////
// UserController
//Route::resource('user', UserController::class);

//Route::post('/login', \App\Http\Controllers\LoginController::class)


////////////////////////////////////////////////////////////////////////
// TODO: Assign a datetime value if user clicked to confirm registration
// Send email to newly registered User
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth', 'verified'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//    ddd($request->attributes());
//    $user->markEmailAsVerified();
    $request->fulfill();
//    echo '<pre>', print_r($request->all()), '</pre>';
//    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


////////////////////////////////////////////////////////////////////////
// Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resource('user', UserController::class);
    Route::resource('category', CategoryController::class);
});
