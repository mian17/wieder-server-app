<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Public route to register a moderator or customer
     * @param StoreUserRequest $request
     * @return Response
     */

    public function register(StoreUserRequest $request)
    {
        try {

            $attributes = $request->all();
            User::create($attributes);

            $desiredRole = UserRole::findOrFail($attributes['role_id']);

            $newlyCreatedUser = User::whereEmail($request->input('email'))->first();
            $newlyCreatedUser->roles()->attach($desiredRole);

            // Authorize User register
//            Auth::login($newlyCreatedUser);

            // Event listener to send email to
            event(new Registered($newlyCreatedUser));
            $roles = $newlyCreatedUser->roles->pluck('role_name')->all();

            $token = $newlyCreatedUser->createToken('user-token', $roles)->plainTextToken;

            $response = [
                'user' => $newlyCreatedUser,
                'token' => $token,
            ];

            return response($response, 201);
        } catch (QueryException $e) {
//            echo '<pre>', print_r($e), '</pre>';
            $response = [
                'message' => 'Không sao lưu được',
                'error' => $e
            ];
            return response($response, 400);
        }
    }

    /**
     * Public route to log in
     * @param LoginRequest $request
     * @return Response
     */

    public function login(LoginRequest $request): Response
    {
        try {
            $attributes = $request->all();

            // Check email
            $user = User::whereEmail($attributes['email'])->first();

            // Check password
            if (!$user || !Hash::check($attributes['password'], $user->password)) {
                return response(['message' => 'Email hoặc mật khẩu sai'], 401);
            }

            if (Auth::attempt($attributes)) {
                if ($user->hasVerifiedEmail()) {
                    $request->session()->regenerate();
                } else {
                    return response(['message' => 'Bạn chưa xác nhận email'], 401);
                }
            }

            if ($user->deleted === 1) {
                return response(['message' => 'Tài khoản của bạn đã bị xóa.'], 401);
            }
            // Assign token abilities according to user's role
//            $authenticatedUser = auth()->user();

//            if ($authenticatedUser->isAdmin()) {
////                echo 'Admin hoặc moderator nè';
//                $token = auth()->user()->createToken('user-token')->plainTextToken;
//
//                $response = [
//                    'user' => $authenticatedUser,
//                    'token' => $token,
//                ];
//
//                return response($response, 201);
//            } else {
////                echo 'Khách hàng nè';
//                $token = auth()->user()->createToken('user-token', [
//                    'customer',
//                ])->plainTextToken;
//
//                $response = [
//                    'user' => $authenticatedUser,
//                    'token' => $token,
//                ];
//
//                return response($response, 201);
//            }

            $roles = $user->roles->pluck('role_name')->all();
//            echo '<pre>', print_r(gettype($roles)), '</pre>';
//            echo '<pre>', print_r([...$roles]), '</pre>';
            $token = $user->createToken('user-token', $roles)->plainTextToken;
            $response = [
                    'user' => $user,
//                    'roles' => $roles,
                    'token' => $token,
            ];
//
            return response($response, 201);


        } catch (QueryException $e) {
            echo "Không sao lưu được";
        }
        return response(['message' => 'Hoàn thành thao tác']);
    }

    /**
     * Logs user out
     *
     * @return Response
     */
    public function logout(Request $request)
    {
//        echo '<pre>', print_r($request->user()), '</pre>';
        auth()->user()->tokens()->delete();

        return response(['message' => 'Bạn đã đăng xuất'], 200);
    }

    /**
     * Ensure admin in order for the client site to render a new menu item
     * called "Trang Admin"
     *
     * @param Request $request
     * @return Application|ResponseFactory|Response|void
     */
    public function checkAdmin(Request $request) {
        $authenticatedUser = auth()->user();
        if ($authenticatedUser->tokenCan('admin')) {
            $hashIsAdmin = 'r6&fekimLPvK3eU897bG3q9oDqFHcCjWMGi8#Dp7D5q6u$nXXPttNMr7nF3szG^A*jLxS53Bhau$Edt!x25^Sjc$q$n6fd9m3Z4wJR7uiNAyKR2r4JPz2hMP59*zc!pP';

            if (Hash::check($hashIsAdmin, $request->header('Hashed'))) {
                return response('', 204);
            }
        } else {
            return response('', 401);
        }
    }

}
