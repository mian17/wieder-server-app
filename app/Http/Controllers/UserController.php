<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(User::all());
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(User::findOrFail($id));
    }

    public function showLoggedInUserInfo()
    {
        $user = auth()->user();

        return response([
            'message' => 'Lấy thông tin người dùng đang đăng nhập thành công',
            'user' => $user

        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param StoreUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public
    function update(StoreUserRequest $request, int $id): JsonResponse
    {
        $attributes = $request->all();

        $editingUser = User::findOrFail($id);
        $editingUser->update($attributes);


        return response()->json(['message' => 'Đã nhận được yêu cầu update và chỉnh sửa thông tin user này thành công']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        //
    }

    /**
     * Get items in a user's cart
     *
     * @param $uuid
     * @return Response
     */
    public function getCartItemsFromAUser($uuid): Response
    {
        $itemsInCart = User::find($uuid)->cartItems;

        return response(['message' => 'Lấy các sản phẩm trong giỏ hàng người dùng thành công', 'itemsInCart' => $itemsInCart]);
    }

}
