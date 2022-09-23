<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
