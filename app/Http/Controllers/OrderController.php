<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
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
        // Payment Details status 1: Chưa thanh toán
        // Payment Details status 2: Đã thanh tón
        DB::transaction(function () use ($request) {

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

                        $kindToUpdateQuantity = Kind::where('id', $item['model_id']);
                        $kindToUpdateQuantity->update(['quantity' => $kindToUpdateQuantity->value('quantity') - $item['quantity']]);
                    }

                    if (auth('sanctum')->user()) {
                        $user_uuid = auth('sanctum')->user()->uuid;
                        CartItem::where('user_uuid', $user_uuid)->delete();
                    }
                }
                return response(['message' => 'Tạo đơn hàng mới và thêm chi tiết đơn hàng thành công'], 200);
            }

            return response(['message' => "Tạo đơn hàng thành công", 200]);
        });

        return response(['message' => 'Transaction finished without any errors'], 200);

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
        $userUuid = auth()->user()->uuid;
        $editingOrder = Order::find($id);
        if (auth()->user()) {
            switch ($request->get('order_status')) {
                case 4:
                    $conditionToChangeToOrderReceivedStatus =
                        $editingOrder->status_id === 1
                        || $editingOrder->status_id === 2
                        || $editingOrder->status_id === 3
                        || $editingOrder->status_id === 6;

                    if ($conditionToChangeToOrderReceivedStatus) {
                        $editingOrder->update(['status_id' => 4]);

                    } else {
                        return response(['message' => 'Yêu cầu không hợp lệ'], 422);
                    }
                    break;
                case 5:
                    echo "Sẽ sửa đổi đơn hàng sang trạng thái hủy";
                    $conditionToChangeToOrderCanceled =
                        $editingOrder->status_id === 1
                        || $editingOrder->status_id === 2
                        || $editingOrder->status_id === 3;

                    if ($conditionToChangeToOrderCanceled) {
                        $editingOrder->update(['status_id' => 5]);
                        $orderItems = DB::table('order_item')->where('order_uuid', $id)->get(['model_id', 'quantity']);
                        foreach($orderItems as $orderItem) {
                            DB::table('model')
                                ->where('id', $orderItem->model_id)
                                ->increment('quantity', $orderItem->quantity);

                        }
//                        return response()->json($orderItems);

                    } else {
                        return response(['message' => 'Yêu cầu không hợp lệ'], 422);
                    }
                    break;
                case 6:
                    echo "Sẽ sửa đổi đơn hàng sang trạng thái đổi trả/hoàn tiền";
                    $conditionToChangeToOrderReturnOrRefund = $editingOrder->status_id === 4;
                    if ($conditionToChangeToOrderReturnOrRefund) {
                        $editingOrder->update(['status_id' => 6]);
                    } else {
                        return response(['message' => 'Yêu cầu không hợp lệ'], 422);
                    }
                    break;
                default:
                    return response([
                        'message' => 'Yêu cầu sửa đổi đơn hàng không hợp lệ',
                        'order' => $editingOrder
                    ], 422);
            }

            return response([
                'message' => 'Đã sửa đổi trạng thái đơn hàng thành công',
                'order' => $editingOrder
            ], 200);
        }

        return response(['message' => 'Bạn không có quyền'], 401);
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

                $kindToUpdateQuantity = Kind::where('id', $item['model_id']);
                $kindToUpdateQuantity->update(['quantity' => $kindToUpdateQuantity->value('quantity') - $item['quantity']]);
            }

            if (auth('sanctum')->user()) {
                $user_uuid = auth('sanctum')->user()->uuid;
                CartItem::where('user_uuid', $user_uuid)->delete();
            }
        }
        return response(['message' => 'Tạo đơn hàng mới và thêm chi tiết đơn hàng thành công'], 200);
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
