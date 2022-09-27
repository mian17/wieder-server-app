<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\EditProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * TODO: SEARCH FUNCTIONALITY
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(['products' => Product::paginate(50)]);
    }

    /**
     * Display a listing for front page
     *
     * @return Response
     */
    public function indexProductsFrontPage(): Response
    {
        $products = Product::with('kinds')->limit(11)->get();
        return response([
            'message' => 'Lấy các sản phẩm cho trang chủ thành công',
            'products' => $products
        ], 200);
    }


//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param StoreProductRequest $request
//     * @return Response
//     */
//    public function store(StoreProductRequest $request): Response
//    {
//        try {
//            $attributes = $request->all();
//            $createdProduct = Product::create($attributes);
//
//            // Many-to-many relationship for products
//            $createdProduct->merchants()->attach($attributes['merchant_id']);
//            $createdProduct->warehouses()->attach($attributes['warehouse_id']);
//
//            return response(['message' => "Tạo sản phẩm mới thành công"], 200);
//        } catch (QueryException $e) {
//            return response(['message' => "Tạo sản phẩm mới không thành công", "error" => $e], 401);
//        }
//    }

    /**
     * Display the specified resource with its kinds.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        // 1st implementation
//        $desiredProduct = Product::with('kinds')->findOrFail($id);

        // 2nd implementation
//        $desiredProduct = DB::table('product')
//            ->where('product.id', $id)
//            ->join('model', 'product.id', '=', 'model.product_id')
//            ->join('image', 'model.id', '=', 'image.model_id')
//            ->select(
//                'model.id as model_id',
//                'product.id as product_id',
//                'product.name as product_name',
//                'model.name as model_name',
//                'image.url as image_url'
//            )
////            ->groupBy('url')
//        ->get();

        // 3rd implementation

        $desiredProduct = Product::find($id)->load(['kinds', 'kinds.images']);
        return response([
            'message' => "Hiển thị sản phẩm thành công",
            "product" => $desiredProduct
        ], 200);
    }

    /**
     * Show product for front page
     *
     * @param int $id
     * @return Response
     */
    public function showProductFrontPage(int $id): Response
    {
        $desiredProduct = Product::with(['kinds'])
            ->where('id', $id)
            ->get();
        return response([
            'message' => "Hiển thị sản phẩm thành công",
            "product" => $desiredProduct
        ], 200);
    }

//    /**
//     * Update the specified resource in storage.
//     *
//     * @param EditProductRequest $request
//     * @param int $id
//     * @return Response
//     */
//    public function update(EditProductRequest $request, int $id): Response
//    {
//        $attributes = $request->all();
////         echo '<pre>', print_r($request->all()), '</pre>';
//        $desiredProduct = Product::findOrFail($id);
//        $desiredProduct->update($attributes);
//
//        return response([
//            'message' => "Cập nhật sản phẩm thành công",
//            "product" => $desiredProduct
//        ], 200);
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        // TODO: DETACH
        Product::find($id)->delete();
        return response(['message' => "Đã xóa nhà bán thành công"], 200);
    }
}
