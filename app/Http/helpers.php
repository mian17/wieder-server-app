<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

if (!function_exists('uploadFile')) {
    /**
     * Receive file request and upload to specified destination.
     *
     * @param $file
     * @param string $publicPath
     * @return string
     */
    function uploadFile($file, string $publicPath): string
    {
        $name = $file->getClientOriginalName();
        $fileName = microtime() . '-' . $name;
        return $file->storeAs($publicPath, $fileName, ['disk' => 'image']);
    }
}
if (!function_exists('joinFileAndInputRequests')) {
    /**
     * Special method for joining files and input requests since they are seperated
     * This is necessary because of the client's layout complexity
     *
     * @param mixed $modelRequests
     * @param array|UploadedFile|null $images
     * @return array|null
     */
    function joinFileAndInputRequests(mixed $modelRequests, array|UploadedFile|null $images): array|null
    {
        $allowedExtensions = ['jpg', 'png', 'jpeg'];
        for ($i = 0, $iMax = count($modelRequests); $i < $iMax; $i++) {
            if ((!array_key_exists('image_1', $modelRequests[$i])
                || !array_key_exists('image_2', $modelRequests[$i]))) {


                if (!array_key_exists('image_1', $modelRequests[$i]) ) {
                    $fileExtension = $images[$i]['image_1']->getClientOriginalExtension();
                    if (in_array($fileExtension, $allowedExtensions, true)) {
                        $modelRequests[$i]['image_1'] = $images[$i]['image_1'];
                    } else {
                        return null;
                    }

                }

                if (!array_key_exists('image_2', $modelRequests[$i]) && $i === 0) {
                    $fileExtension = $images[$i]['image_2']->getClientOriginalExtension();
                    if (in_array($fileExtension, $allowedExtensions, true)) {
                        $modelRequests[$i]['image_2'] = $images[$i]['image_2'];
                    } else {
                        return null;
                    }
                }

            }
        }
        return $modelRequests;
    }
}

if (!function_exists('isImage')) {
    /**
     * Check if file is image, and fit the condition of extensions
     *
     * @param UploadedFile $file
     * @param array $allowedExtensions
     * @return bool
     */
    function isImage(UploadedFile $file, array $allowedExtensions = ['jpg', 'png', 'jpeg']): bool
    {
        $fileExtension = $file->getClientOriginalExtension();
        if (in_array($fileExtension, $allowedExtensions, true)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('resetProductInRelationToKindsQuantity')) {
    /**
     * Reset product quantity according to order quantity
     *
     * @param $uuid
     * @param $oldStatusId
     * @param $conditionToReset
     * @return void
     */
    function resetProductInRelationToKindsQuantity($uuid, $oldStatusId, $conditionToReset): void
    {
        if ($oldStatusId === $conditionToReset) {
            $orderItems = DB::table('order_item')->where('order_uuid', $uuid)->get(['model_id', 'quantity']);
            foreach ($orderItems as $orderItem) {
                DB::table('model')
                    ->where('id', $orderItem->model_id)
                    ->decrement('quantity', $orderItem->quantity);
            }
        }
    }
}
