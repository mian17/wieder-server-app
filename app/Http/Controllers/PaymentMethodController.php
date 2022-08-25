<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentMethod\EditPaymentMethodRequest;
use App\Http\Requests\PaymentMethod\StorePaymentMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(PaymentMethod::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StorePaymentMethodRequest $request
     * @return Response
     */
    public function store(StorePaymentMethodRequest $request)
    {
        try {
            $attributes = $request->all();
            PaymentMethod::create($attributes);
            return response(['message' => "Tạo phương thức thanh toán mới thành công"], 200);
        } catch (QueryException $e) {
            return response(['message' => "Tạo phương thức thanh toán mới không thành công", "error" => $e], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $desiredPaymentMethod = PaymentMethod::findOrFail($id);
        return response(['message' => "Hiển thị phương thức thanh toán thành công", 'merchant' => $desiredPaymentMethod], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param EditPaymentMethodRequest $request
     * @param int $id
     * @return Response
     */
    public function update(EditPaymentMethodRequest $request, int $id): Response
    {
        $attributes = $request->all();
        $desiredPaymentMethod = PaymentMethod::findOrFail($id);
        $desiredPaymentMethod->update($attributes);
        return response(['message' => "Cập nhật phương thức thanh toán thành công", 'discountInfo' => $desiredPaymentMethod], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        PaymentMethod::findOrFail($id)->delete();
        return response(['message' => "Đã xóa phương thức thanh toán thành công"], 200);
    }
}
