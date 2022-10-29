<?php


use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureAdminRole;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Dashboard
Route::get('/', function () {
    return view('welcome');
});

////////////////////////////////////////////////////////////////////////
// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);


Route::post('/admin/login', [UserAdminController::class, 'login'])
    ->middleware(EnsureAdminRole::class);

Route::get('/email/verify/success', function () {
    return view('auth.verify-email-successfully');
});
Route::get('/email/verify/already-success', function () {
    return view('auth.verify-email-already');
});


