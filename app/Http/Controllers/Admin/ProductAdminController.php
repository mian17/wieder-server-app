<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\EditProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Kind;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use JsonException;

class ProductAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
//        return response()->json(['products' => Product::paginate(50)]);

//        $products = Product::with('kinds')->get();

//        $products = DB::table('product')
//            ->join('category', 'product.category_id', '=', 'category.id')
//            ->join('model', 'product.id', '=', 'model.product_id')
//            ->distinct()
//            ->get();


        $products = Product::with(['category', 'kinds', 'merchants', 'warehouses']);

        if ($request->get('filter')) {
            $products
                ->where('product.name', 'LIKE', '%' . $request->get('filter') . '%')
                ->orWhere('product.SKU', 'LIKE', '%' . $request->get('filter') . '%')
                ->orWhere('category.name', 'LIKE', '%' . $request->get('filter') . '%')
                ->limit(10);
        }


        return response()->json($products->paginate(10));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return Response
     */
    public function store(StoreProductRequest $request): Response
    {

        try {

            $attributes = $request->except('merchant_id', 'warehouse_id', 'models');

            if ($attributes['price'] > $attributes['cost_price']) {
                return response(['message' => 'Đơn giá phải bé hơn giá vốn'], 422);
            }

            $createdProduct = Product::create($attributes);

            $hasRelationalKeysForStoringProduct = $request->has('merchant_ids')
                && $request->has('warehouse_ids')
                && $request->has('models');

            if ($hasRelationalKeysForStoringProduct) {
                $decodedMerchantIds = json_decode($request->get('merchant_ids'), false, 512, JSON_THROW_ON_ERROR);
                $decodedWarehouseIds = json_decode($request->get('warehouse_ids'), false, 512, JSON_THROW_ON_ERROR);

                $images = $request->file('models');
                $models = $request->get('models');

                foreach ($decodedMerchantIds as $merchantId) {
                    $createdProduct->merchants()->attach($merchantId);
                }

                foreach ($decodedWarehouseIds as $warehouseId) {
                    $createdProduct->warehouses()->attach($warehouseId);
                }

                for ($i = 0, $iMax = count($models); $i < $iMax; $i++) {
                    foreach ($images[$i] as $key => $image) {
                        $models[$i][$key] = '/' . uploadFile($image, 'img/product');
                    }

                    $models[$i]['product_id'] = $createdProduct->id;
                    Kind::create($models[$i]);
                }
            }

            return response(['message' => "Tạo sản phẩm mới thành công", 'createdProduct' => $createdProduct], 200);
        } catch (QueryException $e) {
            return response(['message' => "Tạo sản phẩm mới không thành công", "error" => $e], 401);
        } catch (JsonException $e) {
            return response(['message' => "JSON decoding process failed ", 'error' => $e], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $desiredProduct = Product::with(['category', 'kinds', 'merchants', 'warehouses'])->whereId($id)->get();

//        return response(['message' => 'Lấy dữ liệu thành công', 'product' => $desiredProduct], 200);
        return response()->json($desiredProduct);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @param int $id
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, $id)
//    {
//        //
//    }

    /**
     *  Update the specified resource in storage with file upload
     *
     * @param EditProductRequest $request
     * @param int $id
     * @return Response
     */
    public function updateProductWithFileUpload(EditProductRequest $request, int $id): Response
    {
        try {
            $attributes = $request->except('merchant_id', 'warehouse_id', 'models');

            $editingProduct = Product::find($id);

            $editingProduct->update($attributes);

            $hasRelationalKeysForStoringProduct = $request->has('merchant_ids')
                && $request->has('warehouse_ids')
                && $request->has('models');

            if ($hasRelationalKeysForStoringProduct) {
                $decodedMerchantIds = json_decode($request->get('merchant_ids'), false, 512, JSON_THROW_ON_ERROR);
                $decodedWarehouseIds = json_decode($request->get('warehouse_ids'), false, 512, JSON_THROW_ON_ERROR);

                $images = $request->file('models');
                // Case 1: No images
                // Case 2: Change only one image
                // Case 3: Change all images
                // Case 4: Remove all models

                $modelChangesRequest = $request->get('models');

                //////////////////////////////////////////////////////////////////////////////////
                // TODO: UNCOMMENT THIS AFTER TESTING
//                $editingProduct->merchants()->sync($decodedMerchantIds);
//
//                $editingProduct->warehouses()->sync($decodedWarehouseIds);

                $incomingRequestHasNoFile = !$images || count($images) === 0;

                // Finding the product's models
                $relatedModels = $editingProduct->kinds;

                //////////////////////////////////////////////////////////////////////////////////
                // Case 1: No images - which means the request has NO specified changes for models
                // Same result for image url in database
                // BUT: USER CAN CHANGE TEXT BASED DATA AND USER HAS NOT BEEN ADDING ANY MODELS
                if ($incomingRequestHasNoFile) {
                    echo 'Không có file';
                    // Check if user has not been adding any more models to the product
                    if (count($modelChangesRequest) === count($relatedModels)) {
                        for ($i = 0, $iMax = count($relatedModels); $i < $iMax; $i++) {
                            // Update model's information according to the request
                            $relatedModels[$i]->update($modelChangesRequest[$i]);

                            if ($i !== 0) {
                                $relatedModels[$i]->update(['image_2' => NULL]);
                            }
                        }
                    }
                }

                //////////////////////////////////////////////////////////////////////////////////
                // Case 2: Has Images - which means the request HAS specified changes for models
                // POSSIBLE USE CASES: 2-1: User changed one of the images for one existing model
                //                     2-2: User changed all images for one existing model
//                echo '<pre>', print_r($incomingRequestHasNoFile), '</pre>';
                if (!$incomingRequestHasNoFile) {
//                    echo "Có file";
                    $modelRequests = $request->input('models');
//                    echo '<pre>', print_r($request->input('models')), '</pre>';

                    // JOINING FILE AND REQUEST INPUT ARRAY FOR ITERATION

                    // IF ARRAY KEY EXISTS, WHICH MEANS THE DATA IS A STRING AND NOT AN UPLOADED FILE
                    // IF ARRAY KEY DOES NOT EXIST, THEN JOIN INPUT FILE DATA WITH INPUT ARRAY
                    $modelRequests = joinFileAndInputRequests($modelRequests, $images);
                    if ($modelRequests === NULL) {
                        return response([
                            'message' => 'Đã có lỗi xảy ra, hãy đảm bảo rằng nội dung bạn muốn thay đổi đúng định dạng, đặc biệt là hình phải có định dạng: png, jpg, jpeg'
                        ], 415);
                    }

                    for ($i = 0, $iMax = count($modelRequests); $i < $iMax; $i++) {
                        $updateModel = [];
                        if (count($modelChangesRequest) === count($relatedModels)) {
                            foreach ($modelRequests[$i] as $key => $inputData) {
                                if (is_string($inputData)) {
                                    $updateModel[$key] = $inputData;
                                } else if (is_file($inputData) && isImage($inputData)) {

                                    $updateModel[$key] = '/' . uploadFile($inputData, 'img/product');
                                }
                            }

                            $relatedModels[$i]->update($updateModel);

                            if ($i !== 0) {
                                $relatedModels[$i]->update(['image_2' => NULL]);
                            }
                        }
                    }
//                    foreach($modelRequests as $requests) {



//                    }
//                    for ($i = 0, $iMax = count($modelRequests); $i < $iMax; $i++) {
//                        foreach ($images[$i] as $key => $image) {
//                            $models[$i][$key] = '/' . uploadFile($image, 'img/product');
//                        }
//
//                        $models[$i]['product_id'] = $editingProduct->id;
//                        Kind::create($models[$i]);
//                    }
//                    for ($i = 0, $iMax = count($relatedModels); $i < $iMax; $i++) {
////                        echo '<pre>', print_r($images[$i]), '</pre>';
////                        foreach ($images[$i] as $image) {
////                            if (is_object($image)) {
////                                echo 'Đây là file';
////
////                                $fileExtension = $image->getClientOriginalExtension();
////                                echo '<pre>', print_r($image), '</pre>';
////
////                                if (in_array($fileExtension, $allowedExtensions, true)) {
////                                    echo 'Và là hình';
////                                    $fileSize = $image->getSize();
////
////                                    echo $fileSize;
////                                } else {
////                                    echo 'Nhưng không phải là hình';
////                                }
////                            } else {
////                                echo 'Đây không phải là file';
////                            }
////                        }
//                    }
                }
            }

            return response(["message' => 'Đã nhận được request update product cho sản phẩm $id"], 200);


        } catch (QueryException $e) {
            return response(['message' => "Tạo sản phẩm mới không thành công", "error" => $e], 401);
        } catch (JsonException $e) {
            return response(['message' => "JSON decoding process failed ", 'error' => $e], 422);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


}
