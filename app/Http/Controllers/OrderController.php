<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentDetails;
use App\Models\Status;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json('orders', Order::paginate(50));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrderRequest $request
     * @return Response
     */
    public function store(StoreOrderRequest $request): Response
    {
        // Payment Details status 1: Chưa thanh toán
        // Payment Details status 2: Đã thanh tón
        $orderAttributes = $request->except('cart');
        $orderAttributes['status_id'] = Status::pluck('id')->first();

        if (auth('sanctum')->user()) {
            $user_uuid = auth('sanctum')->user()->uuid;
            $orderAttributes['user_uuid'] = $user_uuid;
        }

        $createdOrder = Order::create($orderAttributes);
        $createdOrderUuid = $createdOrder->uuid;
        if ($createdOrder) {

            $paymentDetailsAttributes = $request->only('payment_method_id', 'total');
            $paymentDetailsAttributes['status'] = "Chưa thanh toán";

            PaymentDetails::create([
                'uuid' => $createdOrderUuid,
                'payment_method_id' => $paymentDetailsAttributes['payment_method_id'],
                'amount' => $paymentDetailsAttributes['total'],
                'status' => $paymentDetailsAttributes['status']
            ]);

            foreach ($request->get('cart') as $item) {
                $item['order_uuid'] = $createdOrderUuid;
                OrderItem::create($item);
            }

            if (auth('sanctum')->user()) {
                $user_uuid = auth('sanctum')->user()->uuid;
                CartItem::where('user_uuid', $user_uuid)->delete();
            }
        }
        return response(['message' => 'Tạo đơn hàng mới và thêm chi tiết đơn hàng thành công'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {

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
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
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
