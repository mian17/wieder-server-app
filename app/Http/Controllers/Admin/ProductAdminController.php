<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Models\Kind;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
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

            if ($request->has('merchant_ids') && $request->has('warehouse_ids') && $request->has('models')) {
                $decodedMerchantIds = json_decode($request->get('merchant_ids'), false, 512, JSON_THROW_ON_ERROR);
                $decodedWarehouseIds = json_decode($request->get('warehouse_ids'), false, 512, JSON_THROW_ON_ERROR);

                $images = $request->file('models');
                $models = $request->get('models');

                foreach($decodedMerchantIds as $merchantId) {
                    $createdProduct->merchants()->attach($merchantId);
                }
                foreach($decodedWarehouseIds as $warehouseId) {
                    $createdProduct->warehouses()->attach($warehouseId);
                }

                foreach ($models as $model) {
                    echo '<pre>', print_r($model), '</pre>';
                }

                for ($i = 0, $iMax = count($models); $i < $iMax; $i++) {
                    foreach ($images[$i] as $key => $image) {
                        $name = $image->getClientOriginalName();

                        $imageName = microtime() . '-' . $name;

                        $movedFile = $image->storeAs('img/product', $imageName, ['disk' => 'image']);
                        $models[$i][$key] = '/' . $movedFile;
                    }

                    $models[$i]['product_id'] = $createdProduct->id;


                    Kind::create($models[$i]);
                }


            }


            return response(['message' => "Tạo sản phẩm mới thành công", 'createdProduct' => $createdProduct], 200);
        } catch (QueryException $e) {
            return response(['message' => "Tạo sản phẩm mới không thành công", "error" => $e], 401);
        } catch (\JsonException $e) {
            return response(['message' => "JSON decoding process failed ", 'error' => $e], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
