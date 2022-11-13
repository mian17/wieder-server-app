<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\EditProductRequest;
use App\Http\Requests\Product\StoreProductRequest;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
//    /**
//     * Display a listing of the resource.
//     * @return JsonResponse
//     */
//    public function index(): JsonResponse
//    {
////        $searchedProducts = Product::where('name', 'LIKE', '%' . $request->get('search') . '%')->limit(10)->get();
////        return response()->json($searchedProducts);
//
//    }


    /**
     * Return search results
     * Expected behavior: only return products which neither are not hidden nor not in trash state
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $searchedProducts = Product::with('kinds')
            ->where('name', 'LIKE', '%' . $request->route('keyword') . '%')
            ->notHiddenOrMovedToTrashForClientSite()
            ->limit(10)
            ->get();
        return response()->json($searchedProducts);
    }

    /**
     * Display a listing for front page
     * Expected behavior: only return products which neither are not hidden nor not in trash state
     *
     * @return Response
     */
    public function indexProductsFrontPage(): Response
    {
        $products = Product::notHiddenOrMovedToTrashForClientSite()
            ->with(['kinds'])
            ->limit(11)
            ->get();
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
     * Expected behavior: only return products which is not hidden
     * For trash items, it should return but with the button add to cart button disabled.
     * or signify to the user that the product is not available to purchase.
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

        $desiredProduct = Product::notHidden()->findOrFail($id)->load(['kinds', 'kinds.images']);

        return response([
            'message' => "Hiển thị sản phẩm thành công",
            "product" => $desiredProduct
        ], 200);
    }

//    /**
//     * Show product for front page
//     * NOTE: THIS FUNCTION IS RETIRED
//     * @param int $id
//     * @return Response
//     */
//    public function showProductFrontPage(int $id): Response
//    {
//        $desiredProduct = Product::notHidden()
//            ->with(['kinds'])
//            ->where('id', $id)
//            ->get();
//        return response([
//            'message' => "Hiển thị sản phẩm thành công",
//            "product" => $desiredProduct
//        ], 200);
//    }

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
//        //
//        Product::find($id)->delete();
//        return response(['message' => "Đã xóa nhà bán thành công"], 200);
    }

    public function productsOneMayLike()
    {
        if (OrderItem::all()->count() < 10) {
            $products = Product::notHiddenOrMovedToTrashForClientSite()
                ->with('kinds')
                ->inRandomOrder()
                ->limit(3)
                ->get();
        } else {
            $productsIdOneMayLike = DB::table('order_item')
                ->select('product_id', DB::raw('SUM(quantity) as sum_quantity'))
                ->distinct()
                ->join('product', 'order_item.product_id', '=', 'product.id')
                ->whereNotIn('product.status', [-1, "Ẩn"])
                ->groupBy('product_id')
                ->orderByDESC('sum_quantity')
                ->limit(3)
                ->pluck('product_id');

            $products = Product::whereIn('id', $productsIdOneMayLike)
                ->with('kinds')->limit(3)->get();
        }
        return response([
            'message' => 'Lấy các sản phẩm cho trang chủ thành công',
            'products' => $products,
        ], 200);
    }

    /**
     * Show a random spotlight product for front page
     *
     * @return Response
     */
    public function showRandomSpotlightProduct(): Response
    {
        $desiredProduct = Product::inRandomOrder()->notHiddenOrMovedToTrashForClientSite()
            ->with(['kinds'])
            ->first();
        return response([
            'message' => "Hiển thị sản phẩm thành công",
            "product" => $desiredProduct
        ], 200);
    }
}
