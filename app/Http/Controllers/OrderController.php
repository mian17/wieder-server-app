<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Mail\OrderReceived;
use App\Mail\OrderStatusChanged;
use App\Mail\SignifyNewOrderToAdmin;
use App\Models\CartItem;
use App\Models\Discount;
use App\Models\Kind;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentDetails;
use App\Models\Product;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $userUuid = auth()->user()->uuid;

        $orders = DB::table('order')
            ->where('user_uuid', $userUuid)
            ->join('order_item', 'order.uuid', '=', 'order_item.order_uuid')
            ->join('product', 'product.id', '=', 'order_item.product_id',)
            ->join('model', 'model.id', '=', 'order_item.model_id')
            ->select(
                'order.uuid', 'order.total', 'order.status_id', 'order.created_at',
                'product.name AS product_name',
                'model.name AS model_name', 'model.image_1 AS model_image_url',
                'order_item.price', 'order_item.quantity',
            )
            ->orderBy('order.created_at')
            ->get()
            ->groupBy('uuid');

        return response()->json($orders);
    }

    /**
     * Display orders for a specific registered user
     *
     * @param $currentPage
     * @return JsonResponse
     */
    public function indexForLoggedInUser($currentPage): JsonResponse
    {
        $userUuid = auth()->user()->uuid;


        $orders = DB::table('order')
            ->where('user_uuid', $userUuid)
            ->join('order_item', 'order.uuid', '=', 'order_item.order_uuid')
            ->join('product', 'product.id', '=', 'order_item.product_id',)
            ->join('model', 'model.id', '=', 'order_item.model_id')
            ->select(
                'order.uuid', 'order.total', 'order.status_id', 'order.created_at',
                'product.name AS product_name',
                'model.name AS model_name', 'model.image_1 AS model_image_url',
                'order_item.price', 'order_item.quantity',
            )
            ->orderBy('order.created_at')
            ->get()
            ->groupBy('uuid')->toArray();


        $total = count($orders);
        $perPage = 5;

        $currentItems = array_slice($orders, $perPage * ($currentPage - 1), $perPage);

        $paginator = new LengthAwarePaginator($currentItems, $total, $perPage, $currentPage, ['path' => '']);

        return response()->json($paginator);
    }

    /**
     * Display orders for a specific registered user
     *
     * @param int $orderStatusId
     * @param int $currentPage
     * @return JsonResponse
     */
    public function indexForLoggedInUserBasedToOrderStatus(int $orderStatusId, int $currentPage): JsonResponse
    {
        $userUuid = auth()->user()->uuid;

        $orders = DB::table('order')
            ->where('user_uuid', $userUuid)
            ->where('status_id', $orderStatusId)
            ->join('order_item', 'order.uuid', '=', 'order_item.order_uuid')
            ->join('product', 'product.id', '=', 'order_item.product_id',)
            ->join('model', 'model.id', '=', 'order_item.model_id')
            ->select(
                'order.uuid', 'order.total', 'order.status_id', 'order.created_at',
                'product.name AS product_name',
                'model.name AS model_name', 'model.image_1 AS model_image_url',
                'order_item.price', 'order_item.quantity',
            )
            ->orderBy('order.created_at', 'DESC')
            ->get()
            ->groupBy('uuid')->toArray();


        $total = count($orders);
        $perPage = 5;

        $currentItems = array_slice($orders, $perPage * ($currentPage - 1), $perPage);

        $paginator = new LengthAwarePaginator($currentItems, $total, $perPage, $currentPage, ['path' => '']);

        return response()->json($paginator);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreOrderRequest $request
     * @return Response
     */
    public function store(StoreOrderRequest $request): Response
    {
        // Payment Details status 1: Ch??a thanh to??n
        // Payment Details status 2: ???? thanh t??n

        $quantityIsNotPassable = false;
        $kindsToCheckQuantity = [];
        DB::transaction(function () use ($request, &$quantityIsNotPassable, &$kindsToCheckQuantity) {
            // Quantity check
            foreach ($request->get('cart') as $item) {
//                $kindsToCheckQuantity = Kind::where('id', $item['model_id']);
                $checkingItem = Kind::where('id', $item['model_id']);
                if ($checkingItem->value('quantity') - $item['quantity'] < 0) {
                    $quantityIsNotPassable = true;
                    $kindsToCheckQuantity[] = Kind::where('id', $item['model_id'])->first();

                }
            }

            if ($quantityIsNotPassable) {
                return;
            }


            // User is unregistered, proceeds to createOrder function
            if (!$request->filled(['discount_code', 'discount_percent'])) {
                return $this->createOrder($request);
            }

            $orderAttributes = $request->except('cart');
            $orderAttributes['status_id'] = Status::pluck('id')->first();


            if (auth('sanctum')->user()) {
                $user_uuid = auth('sanctum')->user()->uuid;
                $orderAttributes['user_uuid'] = $user_uuid;

                $clientDesiredDiscountCode = Discount::whereName($orderAttributes['discount_code'])->first();

                $discountPercentIsEqual = $clientDesiredDiscountCode->discount_percent === $request->get('discount_percent');


                // Case when user used a discount, it is invalid but still wants to check out
                if ($discountPercentIsEqual === false) {
                    return $this->createOrder($request);
                }

                $user = User::where('uuid', $user_uuid)->first();
                $user->discounts()->attach($clientDesiredDiscountCode);

                $orderAttributes['total'] = $orderAttributes['total']
                    - $clientDesiredDiscountCode->value('discount_percent') * 0.01 * $orderAttributes['total'];

                $createdOrder = Order::create($orderAttributes);
                $createdOrderUuid = $createdOrder->uuid;

                if ($createdOrder) {
                    $paymentDetailsAttributes = $request->only('payment_method_id', 'total');
                    $paymentDetailsAttributes['status'] = "Ch??a thanh to??n";

                    PaymentDetails::create([
                        'uuid' => $createdOrderUuid,
                        'payment_method_id' => $paymentDetailsAttributes['payment_method_id'],
                        'amount' => $paymentDetailsAttributes['total'],
                        'status' => $paymentDetailsAttributes['status']
                    ]);

                    foreach ($request->get('cart') as $item) {
                        $item['order_uuid'] = $createdOrderUuid;
                        OrderItem::create($item);

                        $kindToUpdateQuantity = Kind::where('id', $item['model_id']);
                        $kindToUpdateQuantity->update(['quantity' => $kindToUpdateQuantity->value('quantity') - $item['quantity']]);
                    }


                    if (auth('sanctum')->user()) {
                        $user_uuid = auth('sanctum')->user()->uuid;
                        CartItem::where('user_uuid', $user_uuid)->delete();
                    }

                    Mail::send(new OrderReceived($createdOrder));
                    Mail::send(new SignifyNewOrderToAdmin($createdOrder));
                }
                return response(['message' => 'T???o ????n h??ng m???i v?? th??m chi ti???t ????n h??ng th??nh c??ng'], 200);
            }

            return response(['message' => "T???o ????n h??ng th??nh c??ng", 200]);
        });


        if (!$quantityIsNotPassable) {
            return response(['message' => 'Transaction finished without any errors'], 200);
        }

        ////////////////////////////////////////////////////
        /// Quantity Errors
        $errorMessages = [];
        foreach ($kindsToCheckQuantity as $kindThatHasQuantityError) {
            $errorMessages[] = "S???n ph???m $kindThatHasQuantityError->name ch??? c??n $kindThatHasQuantityError->quantity s??? l?????ng.";
        }


        return response(['error_messages' => $errorMessages], 500);
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
     * @param string $id
     * @return Response
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['order_status' => 'required|integer|numeric|min:1']);

        $hasError = false;
        $errorMessage = '';
        $statusCode = '';

        $REQUEST_CHO_XAC_NHAN = 1;
        $REQUEST_CHO_LAY_HANG = 2;
        $REQUEST_DANG_GIAO = 3;
        $REQUEST_DA_GIAO = 4;
        $REQUEST_DA_HUY = 5;
        $REQUEST_DOI_TRA_HOAN_TIEN = 6;

        DB::transaction(function () use ($REQUEST_DA_HUY, $REQUEST_DA_GIAO, $REQUEST_DOI_TRA_HOAN_TIEN, $REQUEST_DANG_GIAO, $REQUEST_CHO_LAY_HANG, $REQUEST_CHO_XAC_NHAN, $request, $id, &$errorMessage, &$statusCode, &$hasError) {
            $editingOrder = Order::find($id);
            $orderPaymentDetailsToCheck = PaymentDetails::findOrFail($id);
            if (auth()->user()) {
                switch ($request->get('order_status')) {

                    case $REQUEST_CHO_LAY_HANG: {
                        if ($editingOrder->status_id === $REQUEST_CHO_XAC_NHAN) {
                            $editingOrder->update(['status_id' => $REQUEST_CHO_LAY_HANG]);
                        } else {
                            $errorMessage = '????n h??ng c???n ph???i ??? tr???ng th??i Ch??? x??c nh???n th?? m???i ???????c chuy???n sang tr???ng th??i Ch??? l???y h??ng';
                            $statusCode = '422';
                            $hasError = true;
                            return;
                        }
                    }
                    case $REQUEST_DANG_GIAO:
                        if ($editingOrder->status_id === $REQUEST_CHO_LAY_HANG || $editingOrder->status_id === $REQUEST_DOI_TRA_HOAN_TIEN) {
                            $editingOrder->update(['status_id' => $REQUEST_DANG_GIAO]);
                        } else {
                            $errorMessage = '????n h??ng c???n ??? tr???ng th??i Ch??? l???y h??ng ho???c tr???ng th??i H???y y??u c???u ?????i tr???/ho??n ti???n th?? m???i ???????c chuy???n sang tr???ng th??i ??ang giao';
                            $statusCode = '422';
                            $hasError = true;
                            return;
                        }
                        break;
                    case $REQUEST_DA_GIAO:
//                        $conditionToChangeToOrderReceivedStatus =
//                            ($editingOrder->status_id === 1
//                                || $editingOrder->status_id === 2
//                                || $editingOrder->status_id === 3
//                                || $editingOrder->status_id === 6)
//                            && $orderPaymentDetailsToCheck->status === "???? thanh to??n";

                        $conditionToChangeToOrderReceivedStatus =
                            $editingOrder->status_id === $REQUEST_DANG_GIAO // Order status "??ang giao"
                            && $orderPaymentDetailsToCheck->status === "???? thanh to??n";

                        if ($conditionToChangeToOrderReceivedStatus) {
                            $editingOrder->update(['status_id' => $REQUEST_DA_GIAO]); // Order status "???? giao"

                        } else {
                            $errorMessage = '????n h??ng c???n ???????c thanh to??n v?? ??ang ??? tr???ng th??i ??ang giao h??ng th?? y??u c???u c???a b???n m???i ???????c ch???p thu???n';
                            $statusCode = '422';
                            $hasError = true;
                            return;
                        }
                        break;
                    case 5:
                        $conditionToChangeToOrderCanceled =
                            $editingOrder->status_id === $REQUEST_CHO_XAC_NHAN
                            || $editingOrder->status_id === $REQUEST_CHO_LAY_HANG;

                        if ($conditionToChangeToOrderCanceled) {
                            $editingOrder->update(['status_id' => $REQUEST_DA_HUY]);
                            $orderItems = DB::table('order_item')->where('order_uuid', $id)->get(['model_id', 'quantity']);
                            foreach ($orderItems as $orderItem) {
                                DB::table('model')
                                    ->where('id', $orderItem->model_id)
                                    ->increment('quantity', $orderItem->quantity);
                            }
//                        return response()->json($orderItems);

                        } else {
                            $errorMessage = '????n h??ng c???n ph???i ??ang ??? tr???ng th??i Ch??? x??c nh???n ho???c Ch??? l???y h??ng th?? y??u c???u c???a b???n m???i ???????c ch???p thu???n';
                            $statusCode = '422';
                            $hasError = true;
                            return;
                        }
                        break;
                    case 6:
                        $conditionToChangeToOrderReturnOrRefund = $editingOrder->status_id === $REQUEST_DANG_GIAO
                            && $orderPaymentDetailsToCheck->status === "???? thanh to??n";
                        if ($conditionToChangeToOrderReturnOrRefund) {
                            $editingOrder->update(['status_id' => $REQUEST_DOI_TRA_HOAN_TIEN]);
                        } else {
                            $errorMessage = '????n h??ng c???n ph???i ??ang ??? tr???ng th??i ??ang giao h??ng v?? ???? thanh to??n th?? y??u c???u c???a b???n m???i ???????c ch???p thu???n';
                            $statusCode = '422';
                            $hasError = true;
                            return;
                        }
                        break;
                    default:
                        return response([
                            'message' => 'Y??u c???u s???a ?????i ????n h??ng kh??ng h???p l???',
                            'order' => $editingOrder
                        ], 422);
                }

                return response([
                    'message' => '???? s???a ?????i tr???ng th??i ????n h??ng th??nh c??ng',
                    'order' => $editingOrder
                ], 200);
            }
            return response(['message' => 'B???n kh??ng c?? quy???n'], 401);

        });

        if ($errorMessage !== '' && $statusCode !== '' && $hasError) {
            return response(['error_message' => $errorMessage], (int) $statusCode);
        }
        return response(['message' => 'Transaction finished']);


    }

//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param int $id
//     * @return Response
//     */
//    public function destroy($id)
//    {
//        //
//    }

    /**
     * @param StoreOrderRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     */
    public function createOrder(StoreOrderRequest $request): \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\Foundation\Application|Response
    {
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
            $paymentDetailsAttributes['status'] = "Ch??a thanh to??n";

            PaymentDetails::create([
                'uuid' => $createdOrderUuid,
                'payment_method_id' => $paymentDetailsAttributes['payment_method_id'],
                'amount' => $paymentDetailsAttributes['total'],
                'status' => $paymentDetailsAttributes['status']
            ]);

            foreach ($request->get('cart') as $item) {
                $item['order_uuid'] = $createdOrderUuid;
                OrderItem::create($item);

                $kindToUpdateQuantity = Kind::where('id', $item['model_id']);
                $kindToUpdateQuantity->update(['quantity' => $kindToUpdateQuantity->value('quantity') - $item['quantity']]);
            }

            if (auth('sanctum')->user()) {
                $user_uuid = auth('sanctum')->user()->uuid;
                CartItem::where('user_uuid', $user_uuid)->delete();
            }

            Mail::send(new OrderReceived($createdOrder));
            Mail::send(new SignifyNewOrderToAdmin($createdOrder));
        }
        return response(['message' => 'T???o ????n h??ng m???i v?? th??m chi ti???t ????n h??ng th??nh c??ng'], 200);
    }

    /**
     * Helper function for paginate
     *
     * @param $items
     * @param $perPage
     * @param $page
     * @param $options
     * @return LengthAwarePaginator
     */
    public function paginate($items, $perPage = 15, $page = null, $options = ['path' => ""]): LengthAwarePaginator
    {
        if (Paginator::resolveCurrentPage()) {
            $page = $page ?: (Paginator::resolveCurrentPage());
        } else {
            $page = $page ?: (1);
        }

        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage)->values(), $items->count(), $perPage, $page, $options);
    }
}
