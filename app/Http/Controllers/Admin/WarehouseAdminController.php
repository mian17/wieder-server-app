<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Warehouse\EditWarehouseRequest;
use App\Http\Requests\Warehouse\StoreWarehouseRequest;
use App\Models\Warehouse;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WarehouseAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function index(Request $request): JsonResponse|Response
    {
        try {
            $itemPerPage = $request->get('itemPerPage') ?: 10;
            if ($request->has('filter') && strlen($request->get('filter')) > 2) {
                $filter = $request->get('filter');
                $warehouses = Warehouse::whereNull('deleted')
                    ->where('name', 'LIKE', '%' . $filter . '%')
                    ->orWhere('name', 'LIKE', '%' . $filter . '%')
                    ->orWhere('address', 'LIKE', '%' . $filter . '%')
                    ->orWhere('email', 'LIKE', '%' . $filter . '%')
                    ->orWhere('phone_number', 'LIKE', '%' . $filter . '%')
                    ->paginate($itemPerPage);
            } else {
                $warehouses = Warehouse::whereNull('deleted')->paginate($itemPerPage);

            }


            return response()->json($warehouses);
        } catch (QueryException $e) {
            return response(['message' => 'Có lỗi đã xảy ra', 422]);
        }


//        return response()->json(Warehouse::all());
    }

    /**
     * Index for product form
     *
     * @return JsonResponse
     */
    public function indexProduct(): JsonResponse
    {
        return response()->json(Warehouse::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWarehouseRequest $request
     * @return Response
     */
    public function store(StoreWarehouseRequest $request): Response
    {
        try {
            $attributes = $request->all();
            Warehouse::create($attributes);
            return response(['message' => "Tạo nhà kho mới thành công"], 200);
        } catch (QueryException $e) {
            return response(['message' => "Tạo nhà kho mới không thành công", "error" => $e], 401);
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
        $desiredWarehouse = Warehouse::findOrFail($id);

        return response()->json($desiredWarehouse);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param EditWarehouseRequest $request
     * @param int $id
     * @return Response
     */
    public function update(EditWarehouseRequest $request, int $id): Response
    {
        $attributes = $request->all();
        $desiredWarehouse = Warehouse::findOrFail($id);
        $desiredWarehouse->update($attributes);

//        $desiredWarehouse->products()->attach($attributes['product_id']);

        return response(['message' => "Cập nhật nhà kho thành công"], 200);
    }


//    /**
//     * Adding a product to warehouse in warehouse_product pivot table
//     *
//     * @param Request $request
//     * @param int $id
//     * @return Response
//     */
//    public function addProductToWarehouse(Request $request, int $id): Response
//    {
//        $request->validate(['product_id' => 'required|integer|numeric|min:1']);
//
//        Warehouse::find($id)->products()->attach($request->get('product_id'));
//        return response(['message' => "Thêm sản phẩm vào kho thành công"], 200);
//    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        if (user()->auth()->tokenCan('admin')) {
            Warehouse::find($id)->products()->detach();
            Warehouse::find($id)->delete();
            return response(['message' => "Đã xóa nhà kho thành công"], 200);
        }

        return response(['message' => 'Bạn không có quyền xóa'], 401);
    }

    /**
     * Fake delete warehouse
     *
     * @param int $id
     * @return Response
     */
    public function moveToTrash(int $id): Response
    {
        if (auth()->user()->tokenCan('admin')) {
            $desiredWarehouse = Warehouse::findOrFail($id);
            $desiredWarehouse->update(['deleted' => true]);
            return response(['message' => 'Xóa nhà kho thành công'], 200);
        }

        return response(['message' => 'Bạn không có quyền xóa'], 401);
    }
}
