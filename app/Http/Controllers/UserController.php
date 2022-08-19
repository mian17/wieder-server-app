<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Auth\Events\Registered;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest $request
     * @return Response
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $attributes = $request->all();
//            $attributes['password'] = bcrypt($attributes['password']);

            // Magic bcrypt handling for password in UserController
            User::create($attributes);

            $newlyCreatedUserId = User::whereEmail($request->input('email'))->first()->pluck('id');
            $newlyCreatedUser = User::findOrFail($newlyCreatedUserId)->first();

            auth()->login($newlyCreatedUser);
            event(new Registered($newlyCreatedUser));


            $this->attachDesiredRoleToNewlyCreatedUser($attributes['role_id'], $request);
            return response('Bạn đã đăng ký tài khoản thành công', 200);
        } catch (QueryException $e) {
            echo '<pre>', print_r($e), '</pre>';
            echo "Không sao lưu được";
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public
    function show($id)
    {
        return response()->json(User::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreUserRequest $request
     * @param int $id
     * @return Response
     */
    public
    function update(StoreUserRequest $request, $id)
    {
        $attributes = $request->all();
        echo '<pre>', print_r($attributes), '</pre>';
        $editingUser = User::findOrFail($id);
        $editingUser->update($attributes);


        echo '<pre>', print_r($editingUser), '</pre>';
        echo 'Đã nhận được yêu cầu update';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }


    /**
     * Attach desired role form input to newly created user
     *
     * @param $role_id
     * @param StoreUserRequest $request
     * @return void
     */
    public function attachDesiredRoleToNewlyCreatedUser($role_id, StoreUserRequest $request): void
    {
        $desiredRole = UserRole::findOrFail($role_id);
        $newlyCreatedUserId = User::whereEmail($request->input('email'))->first()->pluck('id');

        $newlyCreatedUser = User::findOrFail($newlyCreatedUserId)->first();
        $newlyCreatedUser->roles()->attach($desiredRole);
    }
}
