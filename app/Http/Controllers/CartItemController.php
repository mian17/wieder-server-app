<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

/**
 * Constraints
 * -- Admin and Moderator should not have controls over user cart items
 * -- Cart items should only be display to authorized users
 *
 * ----------------------------------------------------------------
 * TODO:
 * 1 -- Add a cart item to specified user // store method
 * 2 -- Update quantity to a cart item when when user required // update method
 * 3 -- Show method may not necessary // show method
 * 4 --
 *
 */
class CartItemController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'product_id' => 'required|numeric|integer|min:1',
            'model_id' => 'required|numeric|integer|min:1',
            'quantity' => 'required|numeric|integer|min:1'
        ]);

        $attributes = $request->all();
        $attributes['user_uuid'] = $request->user()->uuid;

        $createdCart = CartItem::create($attributes);

        return response([
            'message' => 'Thêm giỏ hàng thành công',
            'createdCart' => $createdCart
        ], 200);

    }

//    /**
//     * Display the specified resource.
//     *
//     * @param int $id
//     * @return Response
//     */
//    public function show($id)
//    {
//        //
//    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id): Response
    {
        $user_uuid = auth()->user()->uuid;
        $request->validate([
            'quantity' => 'required|integer|numeric',
        ]);

        $cartItem = CartItem::where('user_uuid', $user_uuid)
            ->where('id', $id)
            ->update($request->all());


        return response([
            'message' => "Cập nhật giỏ hàng thành công",
            "updatedCart" => $cartItem
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $user_uuid = auth()->user()->uuid;

        CartItem::where('user_uuid', $user_uuid)
            ->where('id', $id)
            ->delete();
        return response([
            'message' => "Xóa sản phẩm khỏi giỏ hàng thành công",
        ], 200);
    }

    /**
     * Return stored cart items from database to a authorized user.
     *
     * @return Response
     */
    public function getCartItemsFromAuthorizedUser(): Response
    {
        $user_uuid = auth()->user()->uuid;

        $cart = DB::table('cart_item')
            ->where('user_uuid', $user_uuid)
            ->join('product', 'product_id', '=', 'product.id')
            ->join('model', 'model_id', '=', 'model.id')
            ->select(
                'cart_item.id',
                'cart_item.product_id',
                'cart_item.model_id',
                'model.image_1',
                'model.name',
                'product.price',
                'cart_item.quantity',
            )
            ->get();

        return response([
            'message' => 'Lấy các sản phẩm trong giỏ hàng người dùng thành công',
            'itemsInCart' => $cart,
        ]);
    }
}
