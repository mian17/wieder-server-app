<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Events\Registered;

use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
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
            auth()->login($newlyCreatedUser);

            // Event listener to send email to
            event(new Registered($newlyCreatedUser));

            $token = $newlyCreatedUser->createToken('user-token')->plainTextToken;

            $response = [
                'user' => $newlyCreatedUser,
                'token' => $token,
            ];

            return response($response, 201);
        } catch (QueryException $e) {
            echo '<pre>', print_r($e), '</pre>';
            echo "Không sao lưu được";
        }

    }

    /**
     * Public route to log in
     * @param StoreUserRequest $request
     * @return Response
     */

    public function login(Request $request)
    {
        try {
            $attributes = $request->validate([
                'email' => 'required|string',
                'password' => 'required|string',
            ]);

            // Check email
            $user = User::whereEmail($attributes['email'])->first();

            // Check password
            if (!$user || !Hash::check($attributes['password'], $user->password))
            {
                return response(['message' => 'Email hoặc mật khẩu sai'], 401);
            }

            $token = $user->createToken('user-token')->plainTextToken;
            $user->markEmailAsVerified();
            if($user->hasVerifiedEmail()) {
                echo "Người dũng đã xác nhận email";
            } else {
                echo "Người dùng chưa xác nhận email";
            }
            echo '<pre>', print_r($user), '</pre>';
            $response = [
                'user' => $user,
                'token' => $token,

            ];

            return response($response, 201);
        } catch (QueryException $e) {
            echo '<pre>', print_r($e), '</pre>';
            echo "Không sao lưu được";
        }

    }

    /**
     * Logs user out
     *
     * @return Response
     */
    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response(['message' => 'Bạn đã đăng xuất'], 200);
    }

    public function logInPage() {
        return view('login');
    }
}
