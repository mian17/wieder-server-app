<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse_product', function (Blueprint $table) {

            $table->bigInteger('id', true);
            $table->integer('warehouse_id')->index('warehouse_id');
            $table->integer('product_id')->index('product_id');

            $table->foreign(['warehouse_id'], 'warehouse_product_ibfk_1')->references(['id'])->on('warehouse');
            $table->foreign(['product_id'], 'warehouse_product_ibfk_2')->references(['id'])->on('product');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_product');
    }
};
