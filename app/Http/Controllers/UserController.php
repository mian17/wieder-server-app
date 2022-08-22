<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;

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
     * Update the specified resource in storage.
     *
     * @param StoreUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public
    function update(StoreUserRequest $request, $id)
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
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }


}
