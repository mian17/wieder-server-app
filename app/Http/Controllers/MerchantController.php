<?php

namespace App\Http\Controllers;

use App\Http\Requests\Merchant\EditMerchantRequest;
use App\Http\Requests\Merchant\StoreMerchantRequest;
use App\Models\Merchant;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Merchant::all());
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMerchantRequest $request
     * @return Response
     */
    public function store(StoreMerchantRequest $request): Response
    {
        try {
            $attributes = $request->all();
            Merchant::create($attributes);
            return response(['message' => "Thêm nhà bán mới thành công"], 200);
        } catch (QueryException $e) {
            return response(['message' => "Thêm nhà bán mới không thành công", "error" => $e], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $desiredMerchant = Merchant::findOrFail($id);

        return response(['message' => "Hiển thị nhà bán thành công", 'merchant' => $desiredMerchant], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param EditMerchantRequest $request
     * @param int $id
     * @return Response
     */
    public function update(EditMerchantRequest $request, int $id): Response
    {
        $attributes = $request->all();
        $desiredMerchant = Merchant::findOrFail($id);
        $desiredMerchant->update($attributes);
        return response(['message' => "Cập nhật nhà bán thành công", 'merchant' => $desiredMerchant], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        Merchant::findOrFail($id)->delete();
        return response(['message' => "Đã xóa nhà bán thành công"], 200);

    }
}
