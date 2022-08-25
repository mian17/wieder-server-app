<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPaymentMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        Schema::table('payment_method', function (Blueprint $table) {
//            $table->foreign(['id'], 'payment_method_ibfk_1')->references(['payment_method_id'])->on('payment_details');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('payment_method', function (Blueprint $table) {
//            $table->dropForeign('payment_method_ibfk_1');
//        });
    }
}
