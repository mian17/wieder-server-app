<?php

namespace App\Http\Controllers;

use App\Http\Requests\Warehouse\StoreWarehouseRequest;
use App\Models\Warehouse;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Warehouse::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWarehouseRequest $request
     * @return Response
     */
    public function store(StoreWarehouseRequest $request): Response
    {
        try {
            $attributes = $request->all();
            Warehouse::create($attributes);
            return response(['message' => "Tạo nhà kho mới thành công"], 200);
        } catch (QueryException $e) {
            return response(['message' => "Tạo nhà kho mới không thành công", "error" => $e], 401);
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
        $desiredWarehouse = Warehouse::findOrFail($id);

        return response(['message' => "Hiển thị nhà kho mới thành công", 'merchant' => $desiredWarehouse], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id): Response
    {
        $attributes = $request->all();
        $desiredWarehouse = Warehouse::findOrFail($id);
        $desiredWarehouse->update($attributes);
        return response(['message' => "Cập nhật nhà kho thành công", 'discountInfo' => $desiredWarehouse], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        Warehouse::findOrFail($id)->delete();
        return response(['message' => "Đã xóa nhà kho thành công"], 200);
    }
}
