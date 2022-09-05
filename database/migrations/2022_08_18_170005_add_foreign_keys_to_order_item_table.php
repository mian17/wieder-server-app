<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_item', function (Blueprint $table) {
            $table->foreign(['order_uuid'], 'order_item_ibfk_1')->references(['uuid'])->on('order');
            $table->foreign(['product_id'], 'order_item_ibfk_2')->references(['id'])->on('product');
            $table->foreign(['model_id'], 'order_item_ibfk_3')->references(['id'])->on('model');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_item', function (Blueprint $table) {
            $table->dropForeign('order_item_ibfk_1');
            $table->dropForeign('order_item_ibfk_2');
            $table->dropForeign('order_item_ibfk_2');
        });
    }
}
