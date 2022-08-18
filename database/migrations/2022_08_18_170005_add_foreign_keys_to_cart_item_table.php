<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToCartItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cart_item', function (Blueprint $table) {
            $table->foreign(['user_id'], 'cart_item_ibfk_3')->references(['id'])->on('user');
            $table->foreign(['product_id'], 'cart_item_ibfk_2')->references(['id'])->on('product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_item', function (Blueprint $table) {
            $table->dropForeign('cart_item_ibfk_3');
            $table->dropForeign('cart_item_ibfk_2');
        });
    }
}
