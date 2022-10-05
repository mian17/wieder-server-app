<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use Illuminate\Http\JsonResponse;

class OrderStatusAdminController extends Controller
{
    /**
     * Get order statuses from `status` table
     * which was specified for order statuses
     *
     * @return JsonResponse
     */
    public function getOrderStatus(): JsonResponse
    {
        $statuses = OrderStatus::all();
        return response()->json($statuses);
    }
}
