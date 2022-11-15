<?php

use App\Models\Order;
use Carbon\Carbon;

if (!function_exists('operateWhenPaymentIsAdvanced')) {
    function operateWhenPaymentIsNotAdvanced(int $requestStatusId, int $REQUEST_DA_GIAO, int $REQUEST_DOI_TRA_HOAN_TIEN, string $uuid, int $oldStatusId, int $REQUEST_DA_HUY, Order $editingOrder): Bool
    {


        if ($requestStatusId === $REQUEST_DA_GIAO || $requestStatusId === $REQUEST_DOI_TRA_HOAN_TIEN) {
            return false;
        }

        resetProductInRelationToKindsQuantity($uuid, $oldStatusId, $REQUEST_DA_HUY);
        $editingOrder->update(['status_id' => $requestStatusId]);
        return true;
    }
}

if (!function_exists('operateWhenPaymentIsAdvanced')) {
    function operateWhenPaymentIsAdvanced(string $uuid, int $oldStatusId, int $REQUEST_DA_HUY, Order $editingOrder, int $requestStatusId, int $REQUEST_DA_GIAO, int $MAXIMUM_OF_DAYS_FOR_ORDER_CHANGE): Bool
    {
        if ($oldStatusId === $REQUEST_DA_GIAO && Carbon::now()->diff($editingOrder->updated_at)->d > $MAXIMUM_OF_DAYS_FOR_ORDER_CHANGE ) {
            return false;
        }

        resetProductInRelationToKindsQuantity($uuid, $oldStatusId, $REQUEST_DA_HUY);
        $editingOrder->update(['status_id' => $requestStatusId]);
        return true;
    }
}
