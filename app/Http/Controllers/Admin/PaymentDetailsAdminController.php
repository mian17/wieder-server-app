<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentDetails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PaymentDetailsAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param string $uuid
     * @return Response
     */
    public function update(Request $request, string $uuid): Response
    {
        $editingPaymentDetails = PaymentDetails::findOrFail($uuid);

        $statusVal = $request->get('status');

        if ($statusVal === 'Chưa thanh toán' || $statusVal === 'Đã thanh toán') {
            $editingPaymentDetails->update(['status' => $statusVal]);
        } else {
            return response(['message' => 'Sai dữ liệu'], 422);
        }

        return response([
            'message' => "Sửa đổi trạng thái thanh toán cho đơn hàng $uuid thành công.",
            'paymentDetails' => $editingPaymentDetails
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
