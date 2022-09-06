<?php

namespace App\Http\Controllers;

use App\Http\Requests\Discount\EditDiscountRequest;
use App\Http\Requests\Discount\StoreDiscountRequest;
use App\Models\Discount;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json(Discount::all());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDiscountRequest $request
     * @return Response
     */
    public function store(StoreDiscountRequest $request): Response
    {
        try {
            $attributes = $request->all();
            Discount::create($attributes);
            return response(['message' => "Tạo mã giảm giá mới thành công"], 200);
        } catch (QueryException $e) {
            return response(['message' => "Tạo mã giảm giá mới không thành công", "error" => $e], 401);
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
        $desiredDiscount = Discount::findOrFail($id);

        return response(['message' => "Hiển thị mã giảm giá thành công", 'merchant' => $desiredDiscount], 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param EditDiscountRequest $request
     * @param int $id
     * @return Response
     */
    public function update(EditDiscountRequest $request, int $id): Response
    {
        $attributes = $request->all();
        $desiredDiscount = Discount::findOrFail($id);
        $desiredDiscount->update($attributes);
        return response(['message' => "Cập nhật mã giảm giá thành công", 'discountInfo' => $desiredDiscount], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id): Response
    {
        Discount::find($id)->delete();
        return response(['message' => "Đã xóa mã giảm giá thành công"], 200);
    }

    /**
     * Check if discount code is available
     *
     * @param Request $request
     * @return Response
     */
    public function checkDiscountCode(Request $request): Response
    {
        $request->validate([
            'discount_code' => 'required|string|min:1',
            'total' => 'required|integer|numeric|min:1',
        ]);

        $user = auth('sanctum')->user();
        if (!$user) {
            return response(['message' => 'Rất tiếc, bạn phải đăng ký mới áp dụng được mã giảm giá'], 401);
        }

        $discountCode = $request->get('discount_code');
        $desiredDiscount = Discount::whereName($discountCode);

        $desiredDiscountForCheckingWithUser = Discount::whereName($discountCode)->first();
        if ($desiredDiscount->exists()) {
            $user_uuid = auth('sanctum')->user()->uuid;
            $user = User::where('uuid', $user_uuid)->first();

            if ($user->discounts->contains($desiredDiscountForCheckingWithUser)) {
                return response(['message' => 'Bạn đã sử dụng mã giảm giá này, hãy sử dụng mã khác nhé'], 410);
            }

            if (Carbon::now() > $desiredDiscount->value('expiration_date')) {
                return response(['message' => 'Xin lỗi, mã giảm giá này đã hết hạn sử dụng, bạn vui lòng dùng mã khác nhé'], 410);
            }

            $totalMoneyInCart = $request->get('total');

            if ($totalMoneyInCart < $desiredDiscount->value('total_money_condition')) {
                $totalMoneyConditionForCart = number_format(
                    $desiredDiscount->value('total_money_condition'),
                    null,
                    ",",
                    "."
                );
                return response(
                    ['message' => "Xin lỗi, tổng số tiền trong giỏ hàng của bạn phải trên $totalMoneyConditionForCart ₫ để áp dụng mã giảm giá "],
                    422
                );
            }

            return response([
                'message' => 'Mã giảm giá này còn sử dụng được',
                'discount_percent' => $desiredDiscount->value('discount_percent')
            ], 200);
        }

        return response(['message' => "Mã giảm giá không tồn tại hoặc đã hết hạn sử dụng"], 400);
    }

}
