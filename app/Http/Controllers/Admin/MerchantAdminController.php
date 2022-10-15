<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\EditMerchantRequest;
use App\Http\Requests\Merchant\StoreMerchantRequest;
use App\Models\Merchant;
use App\Models\Warehouse;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class MerchantAdminController extends Controller
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
                $warehouses = Merchant::whereNull('deleted')
                    ->where('name', 'LIKE', '%' . $filter . '%')
                    ->orWhere('name', 'LIKE', '%' . $filter . '%')
                    ->orWhere('address', 'LIKE', '%' . $filter . '%')
                    ->orWhere('email', 'LIKE', '%' . $filter . '%')
                    ->orWhere('phone_number', 'LIKE', '%' . $filter . '%')
                    ->paginate($itemPerPage);
            } else {
                $warehouses = Merchant::whereNull('deleted')->paginate($itemPerPage);

            }


            return response()->json($warehouses);
        } catch (QueryException $e) {
            return response(['message' => 'Có lỗi đã xảy ra', 422]);
        }

    }

    /**
     * Index for product form
     *
     * @return JsonResponse
     */
    public function indexProduct(): JsonResponse
    {
       return response()->json(Merchant::all());
    }

    /**
     * Display all merchants and their associated products
     *
     * @return Response
     */
    public function indexWithProducts(): Response
    {
        $merchantProducts = Merchant::with('products')->get();
        return response(['message' => "Hiển thị nhà bán thành công", 'merchant' => $merchantProducts], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMerchantRequest $request
     * @return Response
     */
    public function store(StoreMerchantRequest $request): Response
    {
        try {
            $attributes = $request->all();
            Merchant::create($attributes);
            return response(['message' => "Thêm nhà bán mới thành công"], 200);
        } catch (QueryException $e) {
            return response(['message' => "Thêm nhà bán mới không thành công", "error" => $e], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $desiredMerchant = Merchant::findOrFail($id);

        return response(['message' => "Hiển thị nhà bán thành công", 'merchant' => $desiredMerchant], 200);
    }

    /**
     * Display a specific merchant and its products.
     *
     * @param int $merchant_id
     * @return Response
     */
    public function showWithProducts(int $merchant_id): Response
    {
        $desiredMerchant = Merchant::findOrFail($merchant_id);

        // Get products that are associated with this merchant
        $merchantProducts = $desiredMerchant->products()->get();


        return response(['message' => "Hiển thị nhà bán thành công", 'merchant' => $desiredMerchant, 'merchantProducts' => $merchantProducts], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param EditMerchantRequest $request
     * @param int $id
     * @return Response
     */
    public function update(EditMerchantRequest $request, int $id): Response
    {
        $attributes = $request->all();
        $desiredMerchant = Merchant::findOrFail($id);
        $desiredMerchant->update($attributes);

        return response(['message' => "Cập nhật nhà bán thành công", 'merchant' => $desiredMerchant], 200);
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
            Merchant::find($id)->delete();
            return response(['message' => "Đã xóa nhà bán thành công"], 200);
        }

        return response(['message' => 'Bạn không có quyền xóa'], 422);
    }

    /**
     * Fake delete merchant
     *
     * @param int $id
     * @return Response
     */
    public function moveToTrash(int $id): Response
    {
        if (auth()->user()->tokenCan('admin')) {
            $desiredMerchant = Merchant::findOrFail($id);
            $desiredMerchant->update(['deleted' => true]);
            return response(['message' => 'Xóa nhà bán thành công'], 200);
        }

        return response(['message' => 'Bạn không có quyền xóa'], 401);
    }
}
