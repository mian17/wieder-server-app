<?php

namespace App\Http\Controllers;

use App\Http\Requests\Discount\EditDiscountRequest;
use App\Http\Requests\Discount\StoreDiscountRequest;
use App\Models\Discount;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Discount::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDiscountRequest $request
     * @return Response
     */
    public function store(StoreDiscountRequest $request)
    {
        try {
            $attributes = $request->all();
            Discount::create($attributes);
            return response(['message' => "Tạo mã giảm giá mới thành công"], 200);
        } catch (QueryException $e) {
            return response(['message' => "Tạo mã giảm giá mới không thành công", "error" => $e], 401);
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
        $desiredDiscount = Discount::findOrFail($id);

        return response(['message' => "Hiển thị mã giảm giá thành công", 'merchant' => $desiredDiscount], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param EditDiscountRequest $request
     * @param int $id
     * @return Response
     */
    public function update(EditDiscountRequest $request, int $id): Response
    {
        $attributes = $request->all();
        $desiredDiscount = Discount::findOrFail($id);
        $desiredDiscount->update($attributes);
        return response(['message' => "Cập nhật mã giảm giá thành công", 'discountInfo' => $desiredDiscount], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        Discount::findOrFail($id)->delete();
        return response(['message' => "Đã xóa mã giảm giá thành công"], 200);
    }
}
