<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\EditProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UploadImagesForModelRequest;
use App\Models\CartItem;
use App\Models\Kind;
use App\Models\KindImage;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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


        $products = Product::with(['category', 'kinds', 'merchants', 'warehouses'])
            ->where('status', '=', 'Hiển thị')
            ->orWhere('status', '=', 'Ẩn');

        if ($request->get('filter')) {
            $products
                ->where('product.name', 'LIKE', '%' . $request->get('filter') . '%')
//                ->orWhere('product.SKU', 'LIKE', '%' . $request->get('filter') . '%')
//                ->orWhere('category.name', 'LIKE', '%' . $request->get('filter') . '%')
                ->limit(10);
        }


        return response()->json($products->paginate(10));
    }


    /**
     * Get all products, this route is responsible for adding images for product details page.
     *
     * @return JsonResponse
     */
    public function productIndexForImage(): JsonResponse
    {
        $products = Product::get(['id', 'name']);
        return response()->json($products);
    }

    /**
     * Get models related to the selected product
     *
     * @param int  $productId
     * @return JsonResponse
     */
    public function modelIndexForImage(int $productId): JsonResponse
    {
        $models = Kind::where('product_id', $productId)->get(['id', 'name']);
//        echo '<pre>', print_r($models), '</pre>';
        return response()->json($models);
    }

    /**
     * Upload images to a specific model
     *
     * @param UploadImagesForModelRequest $request
     * @return Response
     */
    public function uploadImagesForModel(UploadImagesForModelRequest $request): Response
    {
        $productId = $request->get('product_id');
        $modelId = $request->get('model_id');
        $requestImages = $request->file('images');

        $editingProduct = Product::findOrfail($productId);
        $editingModel = Kind::findOrFail($modelId);

        if ($editingProduct && $editingModel) {
            $existingImages = $editingModel->images;
            foreach($existingImages as $image) {
                $image->delete();
            }

            foreach($requestImages as $requestImage) {
                $movedPath = '/' . uploadFile($requestImage, 'img/product');
                KindImage::create(['model_id' => $modelId, 'url' => $movedPath]);
            }
        }

        return response(['message' => 'Tải hình ảnh mới cho sản phẩm thành công']);
    }

//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return Response
//     */
//    public function create()
//    {
//        //
//    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductRequest $request
     * @return Response
     */
    public function store(StoreProductRequest $request): Response
    {

        try {
            DB::beginTransaction();
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
            DB::commit();
            return response(['message' => "Tạo sản phẩm mới thành công", 'createdProduct' => $createdProduct], 200);
        } catch (QueryException $e) {
            DB::rollback();
            return response(['message' => "Tạo sản phẩm mới không thành công", "error" => $e], 401);
        } catch (JsonException $e) {
            DB::rollback();
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
     * @return Response
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
                $modelChangesRequest = $request->get('models');

                //////////////////////////////////////////////////////////////////////////////////
                //
                $editingProduct->merchants()->sync($decodedMerchantIds);
                $editingProduct->warehouses()->sync($decodedWarehouseIds);

                $incomingRequestHasNoFile = !$images || count($images) === 0;

                // Finding the product's models
                $relatedModels = $editingProduct->kinds;

                //////////////////////////////////////////////////////////////////////////////////
                // Case 1: No images - which means the request has NO specified changes for models
                // Same result for image url in database
                // BUT: USER CAN CHANGE TEXT BASED DATA AND USER HAS NOT BEEN ADDING ANY MODELS
                // Check if user has not been adding any more models to the product
                if ($incomingRequestHasNoFile && count($modelChangesRequest) === count($relatedModels)) {
                    for ($i = 0, $iMax = count($relatedModels); $i < $iMax; $i++) {
                        // Update model's information according to the request
                        $relatedModels[$i]->update($modelChangesRequest[$i]);

                        if ($i !== 0) {
                            $relatedModels[$i]->update(['image_2' => NULL]);
                        }
                    }
                }

                //////////////////////////////////////////////////////////////////////////////////
                // Case 2: Has Images - which means the request HAS specified changes for models
                // POSSIBLE USE CASES: 2-1: User changed one of the images for one existing model
                //                     2-2: User changed all images for one existing model
                if (!$incomingRequestHasNoFile) {
                    $modelRequests = $request->input('models');
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

                }
            }
            return response(["message' => 'Cập nhật thông tin cho sản phẩm có $id thành công"], 200);
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
     * @return Response
     */
    public function destroy(int $id): Response
    {
        if (auth()->user()->tokenCan('admin')) {
            $productReadyForDeletion = Product::find($id);

            // Status code in trash, since status column is varchar, strict comparison as string is necessary
            if ($productReadyForDeletion && $productReadyForDeletion->status === "-1") {
                $relatedCarts = CartItem::whereProductId($id)->get();
                $relatedKinds = Kind::whereProductId($id)->get();
//            $relatedImages = Image::whereProductId($id)->get();
                foreach ($relatedCarts as $cart) {
                    $cart->delete();
                }

                foreach ($relatedKinds as $kind) {
                    foreach ($kind->images as $image) {
                        $image->delete();
                    }

                    $kind->delete();
                }


                $productReadyForDeletion->merchants()->detach();
                $productReadyForDeletion->warehouses()->detach();


                $productReadyForDeletion->delete();
            }
            return response(['message' => 'Xóa sản phẩm vĩnh viễn thành công'], 200);

        }

//        Product::find($id)->delete();
        return response(['message' => 'Chỉ có admin mới có quyền xóa sản phẩm'], 401);
    }

    /**
     * Move a specified resource to trash for easy recovery
     * if something accidentally goes wrong on user's end
     * @param int $id
     * @return Response
     */
    public function moveItemToTrash(int $id): Response
    {
        $productReadyForMovingToTrash = Product::find($id);

        $productReadyForMovingToTrash->update(['status' => -1]);

        return response(['message' => 'Di chuyển sản phẩm vào thùng rác thành công'], 200);
    }

    /**
     * Move a specified resource out of trash
     * @param int $id
     * @return Response
     */
    public function restoreItem(int $id): Response
    {
        $productReadyForRestoring = Product::find($id);

        $productReadyForRestoring->update(['status' => "Ẩn"]);

        return response(['message' => 'Khôi phục sản phẩm thành công'], 200);
    }

    /**
     * Get products that are in trash
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function itemsInTrashIndex(Request $request): JsonResponse
    {
        $productsThatAreInTrash = Product::with(['category', 'kinds', 'merchants', 'warehouses'])
            ->where('status', '=', -1);
        if ($request->get('filter')) {
            $productsThatAreInTrash
                ->where('product.name', 'LIKE', '%' . $request->get('filter') . '%')
//                ->orWhere('product.SKU', 'LIKE', '%' . $request->get('filter') . '%')
//                ->orWhere('category.name', 'LIKE', '%' . $request->get('filter') . '%')
                ->limit(10);
        }

        return response()->json($productsThatAreInTrash->paginate(10));
    }

}
