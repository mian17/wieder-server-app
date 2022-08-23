<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('merchant_id')->index('merchant_id');
            $table->integer('category_id')->index('category_id');
            $table->bigInteger('discount_id')->index('discount_id');
            $table->text('warehouse_id_group');
            $table->string('name')->unique('name');
            $table->text('summary');
            $table->text('desc');
            $table->text('detail_info');
            $table->string('quantity');
            $table->string('SKU')->unique('SKU');
            $table->integer('mass');
            $table->integer('cost_price');
            $table->integer('price');
            $table->string('unit');
            $table->string('status');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
