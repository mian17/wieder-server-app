<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function login(LoginRequest $request)
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

            // Assign token abilities according to user's role
            $authenticatedUser = auth()->user();

            $roles = $authenticatedUser->roles->pluck('role_name')->all();
            $token = $authenticatedUser->createToken('user-token', $roles)->plainTextToken;
            $response = [
                'user' => $authenticatedUser,
                'token' => $token,
            ];

            return response($response, 201);


        } catch (QueryException $e) {
            echo "Không sao lưu được";
        }
        return response(['message' => 'Hoàn thành thao tác']);
    }


    /**
     * Show logged-in user info without specifying a uuid for route
     *
     * @return Response
     */
    public function showLoggedInUserInfo(): Response
    {
        $user = auth()->user();

        return response([
            'message' => 'Lấy thông tin người dùng đang đăng nhập thành công',
            'user' => $user
        ]);
    }
}
