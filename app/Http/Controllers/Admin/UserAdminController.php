<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        $ORDER_STATUS_DA_HUY = 5;
        try {
            $itemPerPage = $request->get('itemPerPage') ?: 10;

            if ($request->has('filter') && strlen($request->get('filter')) > 2) {
                $filter = $request->get('filter');
                $users = User::whereNull('deleted')
                    ->where('uuid', 'LIKE', '%' . $filter . '%')
                    ->orWhere('name', 'LIKE', '%' . $filter . '%')
                    ->orWhere('email', 'LIKE', '%' . $filter . '%')
                    ->orWhere('phone_number', 'LIKE', '%' . $filter . '%')
                    ->withSum(['orders AS total_money_spent' => fn($query) => $query->where('status_id', 'NOT', $ORDER_STATUS_DA_HUY)], 'total')->paginate($itemPerPage);
            } else {
                $users = User::whereNull('deleted')->withSum(['orders AS total_money_spent' => fn($query) => $query->where('status_id', 'NOT', $ORDER_STATUS_DA_HUY)], 'total')->paginate($itemPerPage);

            }
            return response()->json($users);
        } catch (QueryException $e) {
            return response(['message' => 'Có lỗi đã xảy ra', 422]);
        }
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function show(string $uuid): JsonResponse
    {
        $user = User::with('orders')->findOrFail($uuid);
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
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

            if ($authenticatedUser->isAdminOrModerator()) {
                $roles = $authenticatedUser->roles->pluck('role_name')->all();
                $token = $authenticatedUser->createToken('user-token', $roles)->plainTextToken;
                $response = [
                    'user' => $authenticatedUser,
                    'token' => $token,
                ];


                return response($response, 201);
            }
            return response(['message' => 'Bạn không có quyền truy cập trang này.']);


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

    /**
     * Move a user to trash
     *
     * @param string $uuid
     * @return Response
     */
    public function moveToTrash(string $uuid): Response
    {
        $user = User::findOrFail($uuid);
        if ($user->isAdmin()) {
            return response(['message' => 'Đây là người dùng admin, không thể xóa người dùng này.'], 401);
        }
        $user->update(['deleted' => true]);

        return response(['message' => 'Xóa người dùng thành công'], 200);
    }

    /**
     * Restore a user, enabling they to continue using the site
     * according to their roles
     *
     * @param string $uuid
     * @return Response
     */
    public function restoreUser(string $uuid): Response
    {
        $user = User::findOrFail($uuid);
        $user->update(['deleted' => NULL]);

        return response(['message' => 'Đưa người dùng vào thùng rác thành công', 200]);
    }
}
