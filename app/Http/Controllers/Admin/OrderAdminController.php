<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChartAnalysisBasedOnYearRequest;
use App\Http\Requests\Order\EditOrderRequest;
use App\Mail\OrderStatusChanged;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;


class OrderAdminController extends Controller
{
    public int $MAXIMUM_OF_DAYS_FOR_ORDER_CHANGE = 7;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
//        $orders = Order::orderByDesc('created_at')->first()->paymentDetails()->paginate(10);
        $filter = $request->get('filter');

        $orders = Order::where('uuid', 'LIKE', '%' . $filter . '%')
            ->orWhere('receiver_name', 'LIKE', '%' . $filter . '%')
            ->orWhere('receiver_email', 'LIKE', '%' . $filter . '%')
            ->orWhere('receiver_phone_number', 'LIKE', '%' . $filter . '%')
            ->orWhere('receiver_address', 'LIKE', '%' . $filter . '%')
            ->with('paymentDetails.methods')
            ->paginate(10);


        return response()->json($orders);
    }


//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param Request $request
//     * @return Response
//     */
//    public function store(Request $request)
//    {
//        //
//    }

    /**
     * Display the specified resource.
     *
     * @param string $uuid
     * @return JsonResponse
     */
    public function show(string $uuid): JsonResponse
    {
        $order = DB::table('order')
            ->where('order.uuid', $uuid)
            ->join('order_item', 'order.uuid', '=', 'order_item.order_uuid')
            ->join('payment_details', 'order.uuid', '=', 'payment_details.uuid')
            ->join('payment_method', 'payment_details.payment_method_id', '=', 'payment_method.id')
            ->join('product', 'product.id', '=', 'order_item.product_id',)
            ->join('model', 'model.id', '=', 'order_item.model_id')
            ->select(
                'order.uuid', 'order.total', 'order.status_id', 'order.created_at', 'order.receiver_address', 'order.receiver_email', 'order.receiver_name', 'order.receiver_phone_number',
                'payment_details.amount', 'payment_details.status',
                'payment_method.name AS payment_method',
                'product.name AS product_name',
                'model.name AS model_name', 'model.image_1 AS model_image_url',
                'order_item.price', 'order_item.quantity',
            )
            ->get()
            ->toArray();
        return response()->json($order);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param EditOrderRequest $request
     * @param string $uuid
     * @return Response
     */
    public function update(EditOrderRequest $request, string $uuid): Response
    {
        $REQUEST_DA_GIAO = 4;

        $editingOrder = Order::findOrFail($uuid);
        $editingPaymentDetails = PaymentDetails::findOrFail($uuid);
        if ($editingOrder->status_id === $REQUEST_DA_GIAO
            && $editingPaymentDetails->status === "Đã thanh toán") {
            return response(['message' => 'Đơn hàng này đã được giao và thanh toán thành công, bạn không được thay đổi thông tin đơn hàng này'], 200);
        }


        $editingOrder->update([
            'receiver_name' => $request->get('receiver_name'),
            'receiver_email' => $request->get('receiver_email'),
            'receiver_phone_number' => $request->get('receiver_phone_number'),
            'receiver_address' => $request->get('receiver_address'),
        ]);

        return response(['message' => 'Đã cập nhật thông tin đơn hàng thành công'], 200);
    }

    /**
     * Update order status
     *
     * @param Request $request
     * @param string $uuid
     * @return Response
     */
    public function updateOrderStatus(Request $request, string $uuid): Response
    {
        $editingOrder = Order::findOrFail($uuid);
        $oldStatusId = $editingOrder->status_id;
        $requestStatusId = (int)$request->get('status_id');

        $REQUEST_DA_GIAO = 4;
        $REQUEST_DA_HUY = 5;
        $REQUEST_DOI_TRA_HOAN_TIEN = 6;

        switch ($editingOrder->paymentDetails->status) {
            case "Chưa thanh toán":
                $processResultSuccess = operateWhenPaymentIsNotAdvanced($requestStatusId, $REQUEST_DA_GIAO, $REQUEST_DOI_TRA_HOAN_TIEN, $uuid, $oldStatusId, $REQUEST_DA_HUY, $editingOrder);
                if (!$processResultSuccess) {
                    return response(['message' => 'Đơn hàng chưa được thanh toán.'], 422);
                }
                break;
            case 'Đã thanh toán':
                $processResultSuccess = operateWhenPaymentIsAdvanced($uuid, $oldStatusId, $REQUEST_DA_HUY, $editingOrder, $requestStatusId, $REQUEST_DA_GIAO, $this->MAXIMUM_OF_DAYS_FOR_ORDER_CHANGE);
                if (!$processResultSuccess) {
                    return response(['message' => 'Đơn hàng này đã giao hàng thành công và đã được thanh toán. Bạn không thể thay đổi trạng thái của đơn hàng này được'], 422);
                }
                break;
            default:
                return response(['message' => "Có lỗi xảy ra"], 422);
        }
//        Mail::send(new OrderStatusChanged($editingOrder, $oldStatusId, $requestStatusId));


        return response(['message' => "Đã cập nhật trạng thái mới cho đơn hàng $uuid thành công"], 200);
    }


//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param string $uuid
//     * @return Response
//     */
//    public function destroy(string $uuid): Response
//    {
//        $orderItems = OrderItem::where('order_uuid', $uuid)->get();
//        foreach ($orderItems as $orderItem) {
//            $orderItem->where('order_uuid', $uuid)->delete();
//        }
//        PaymentDetails::findOrFail($uuid)->delete();
//        Order::findOrFail($uuid)->delete();
//
//        return response(['message' => 'Đã xóa đơn hàng thành công'], 200);
//    }

    /**
     * Get number of orders based on requested year
     * from 2022
     *
     * @param ChartAnalysisBasedOnYearRequest $request
     * @return JsonResponse
     */
    public function chartAnalysisOnOrderCount(ChartAnalysisBasedOnYearRequest $request): JsonResponse
    {
        $requestedYear = Carbon::create($request->get('year'));
        $ordersBasedOnMonth = [];

        for ($i = 1; $i <= 12; $i++) {
            $ordersBasedOnMonth[] = Order::whereYear('created_at', '=', $requestedYear)
                ->whereMonth('created_at', $i)
                ->count();
        }
        return response()->json($ordersBasedOnMonth);
    }

    /**
     * Get revenue from orders
     *
     * @param ChartAnalysisBasedOnYearRequest $request
     * @return JsonResponse
     */
    public function chartAnalysisOnOrderRevenue(ChartAnalysisBasedOnYearRequest $request): JsonResponse
    {
        $requestedYear = Carbon::create($request->get('year'));
        $revenueBasedOnMonth = [];

        for ($i = 1; $i <= 12; $i++) {
            $ordersExistInTheMonth = Order::whereYear('created_at', '=', $requestedYear)
                ->whereMonth('created_at', $i)->exists();

            if ($ordersExistInTheMonth) {
                $revenueBasedOnMonth[] = Order::whereYear('created_at', '=', $requestedYear)
                    ->whereMonth('created_at', $i)->sum('total');
            } else {
                $revenueBasedOnMonth[] = 0;
            }
        }
        return response()->json($revenueBasedOnMonth);
    }


}
