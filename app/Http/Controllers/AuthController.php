<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Auth\Events\Registered;
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

            $token = $newlyCreatedUser->createToken('user-token')->plainTextToken;

            $response = [
                'user' => $newlyCreatedUser,
                'token' => $token,
            ];

            return response($response, 201);
        } catch (QueryException $e) {
//            echo '<pre>', print_r($e), '</pre>';
            $response = [
                'message' => 'Không sao lưu được'
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
            if (!$user || !Hash::check($attributes['password'], $user->password))
            {
                return response(['message' => 'Email hoặc mật khẩu sai'], 401);
            }

            if (Auth::attempt($attributes)) {
                if ($user->hasVerifiedEmail()) {
                    $request->session()->regenerate();
                } else {
                    return response(['message' => 'Bạn chưa xác nhận email'], 401);
                }
            }

            $token = auth()->user()->createToken('user-token')->plainTextToken;
            $user = auth()->user();

            $response = [
                'user' => $user,
                'token' => $token,
            ];

            return response($response, 201);
        } catch (QueryException $e) {
            echo "Không sao lưu được";
        }
        return response(['message'=> 'Hoàn thành thao tác']);
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


}
