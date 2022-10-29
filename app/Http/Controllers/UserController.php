<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\ChangeUserPasswordRequest;
use App\Http\Requests\User\EditUserRequest;
use App\Http\Requests\User\StoreAvatarImageRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
//use Illuminate\Support\Facades\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * not implemented in client
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
     * Update user info without specifying user's uuid
     *
     * @param EditUserRequest $request
     * @return Response
     */
    public function updateLoggedInUserInfo(EditUserRequest $request): Response
    {

        $attributes = $request->except('role_id');

        $userUuid = auth()->user()->uuid;

        $editingUser = User::findOrFail($userUuid);


        if ($attributes['email'] === $editingUser->email) {
            echo 'test';
            $editingUser->update($attributes);
        } else {
            if ($editingUser->hasVerifiedEmail()) {
                $editingUser->update($attributes);
                $editingUser->update(['email_verified_at' => NULL]);
                $editingUser->sendEmailVerificationNotification();
            }
        }


        return response([
            'message' => 'Đã nhận được yêu cầu update và chỉnh sửa thông tin user này thành công',
            'user' => $editingUser
        ]);
    }

    /**
     * Update user's avatar
     *
     * @param StoreAvatarImageRequest $request
     * @return Response
     */
    public function updateAvatar(StoreAvatarImageRequest $request): Response
    {

        $attributes = [];

        if ($request->hasFile('avatar_file')) {
            $uploadedFile = $request->file('avatar_file');
            $name = $uploadedFile->getClientOriginalName();

            $imageName = microtime() . '-' . $name;

            $movedFile = $uploadedFile->storeAs('img/avatar', $imageName, ['disk' => 'image']);
            $attributes['avatar_url'] = '/' . $movedFile;
        }

        $userUuid = auth()->user()->uuid;
        $editingUser = User::findOrFail($userUuid);

        // user's avatar is not default then delete it
        if ($editingUser->avatar !== "/img/avatar/default-avatar.png") {
            File::delete(public_path((string)$editingUser->avatar));
        }

        $editingUser->update(['avatar' => $attributes['avatar_url']]);

        return response(['message' => "Đổi hình ảnh người dùng thành công"]);
    }

    public function changePassword(ChangeUserPasswordRequest $request): Response
    {
        $oldPassword = $request->get('old_password');
        $loggedInUserUuid = auth()->user()->uuid;
        $loggedInUser = User::find($loggedInUserUuid);

        if (Hash::check($oldPassword, $loggedInUser->password)) {

            $newPassword = $request->get('password');
            $newPasswordConfirmation = $request->get('password_confirmation');

            if ($newPassword === $newPasswordConfirmation) {
                if ($oldPassword === $newPassword) {
                    return response(['message' => 'Hãy đảm bảo rằng mật khẩu cũ và mật khẩu mới của bạn không giống nhau'], 422);
                }


                $loggedInUser->update(['password' => $newPassword]);
                return response(['message' => 'Đổi mật khẩu thành công']);
            }

            return response(['message' => 'Mật khẩu mới không giống nhau'], 422);
        }

        return response(['message' => 'Mật khẩu cũ sai, bạn vui lòng kiểm tra lại nhé.'], 401);
    }


//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param int $id
//     * @return Response
//     */
//    public function destroy(int $id)
//    {
//        //
//    }

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

    /**
     * If receiver info is the authorized user
     *
     * @return JsonResponse
     */
    public function autoCompleteInputField(): JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['error' => 'Bạn chưa đăng nhập']);
        }
        return response()->json($user);
    }
}
