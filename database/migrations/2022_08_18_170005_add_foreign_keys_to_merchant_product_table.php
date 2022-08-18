<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMerchantProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('merchant_product', function (Blueprint $table) {
            $table->foreign(['merchant_id'], 'merchant_product_ibfk_1')->references(['id'])->on('merchant');
            $table->foreign(['product_id'], 'merchant_product_ibfk_2')->references(['merchant_id'])->on('product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('merchant_product', function (Blueprint $table) {
            $table->dropForeign('merchant_product_ibfk_1');
            $table->dropForeign('merchant_product_ibfk_2');
        });
    }
}
