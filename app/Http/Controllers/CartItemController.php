<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
            'user_uuid' => 'required|string',
            'product_id' => 'required|numeric|integer|min:1',
            'quantity' => 'required|numeric|integer|min:1'
        ]);

        $attributes = $request->all();

        CartItem::create($attributes);
        return response(['message' => 'Đã thêm sản phẩm vào giỏ hàng người dùng thành công'], 200);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
