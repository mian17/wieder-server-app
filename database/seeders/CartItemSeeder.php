<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CartItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $adminUserUuid = User::whereUsername('admin')->pluck('uuid')->first();
        $products = Product::all()->pluck('id')->toArray();

        // Admin cart
        CartItem::create([
            'user_uuid' => $adminUserUuid,
            'product_id' => $products[random_int(0, 13)],
            'quantity' => fake()->randomNumber(2, true)
        ]);
        CartItem::create([
            'user_uuid' => $adminUserUuid,
            'product_id' => $products[random_int(0, 13)],
            'quantity' => fake()->randomNumber(2, true)
        ]);
        CartItem::create([
            'user_uuid' => $adminUserUuid,
            'product_id' => $products[random_int(0, 13)],
            'quantity' => fake()->randomNumber(2, true)
        ]);
        CartItem::create([
            'user_uuid' => $adminUserUuid,
            'product_id' => $products[random_int(0, 13)],
            'quantity' => fake()->randomNumber(2, true)
        ]);

        // User seed cart
        $userUuid = User::latest()->pluck('uuid')->first();

        CartItem::create([
            'user_uuid' => $userUuid,
            'product_id' => $products[random_int(0, 13)],
            'quantity' => fake()->randomNumber(2, true)
        ]);
        CartItem::create([
            'user_uuid' => $userUuid,
            'product_id' => $products[random_int(0, 13)],
            'quantity' => fake()->randomNumber(2, true)
        ]);
        CartItem::create([
            'user_uuid' => $userUuid,
            'product_id' => $products[random_int(0, 13)],
            'quantity' => fake()->randomNumber(2, true)
        ]);
    }
}
