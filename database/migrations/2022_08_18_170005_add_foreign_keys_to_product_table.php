<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product', function (Blueprint $table) {
//            $table->foreign(['discount_id'], 'product_ibfk_2')->references(['id'])->on('discount');
            $table->foreign(['category_id'], 'product_ibfk_1')->references(['id'])->on('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product', function (Blueprint $table) {
            $table->dropForeign('product_ibfk_2');
            $table->dropForeign('product_ibfk_3');
        });
    }
}
