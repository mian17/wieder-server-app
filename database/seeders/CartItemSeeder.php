<?php

namespace Database\Seeders;

use App\Models\CartItem;
use App\Models\Kind;
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

        // Admin cart
        for ($i = 0; $i < 3; $i++) {
            $productId = Product::inRandomOrder()->first()->id;
            $kindId = Kind::where('product_id', $productId)->inrandomOrder()->first()->id;

            CartItem::create([
                'user_uuid' => $adminUserUuid,
                'product_id' => $productId,
                'model_id' => $kindId,
                'quantity' => fake()->randomNumber(2, true)
            ]);
        }



        // User seed cart
        $userUuid = User::latest()->pluck('uuid')->first();

        for ($i = 0; $i < 3; $i++) {
            $productId = Product::inRandomOrder()->first()->id;
            $kindId = Kind::where('product_id', $productId)->inrandomOrder()->first()->id;

            CartItem::create([
                'user_uuid' => $userUuid,
                'product_id' => $productId,
                'model_id' => $kindId,
                'quantity' => fake()->randomNumber(2, true)
            ]);
        }
    }
}
