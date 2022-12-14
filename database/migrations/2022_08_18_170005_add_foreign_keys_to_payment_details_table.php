<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToPaymentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_details', function (Blueprint $table) {
//            $table->foreign(['id'], 'payment_details_ibfk_1')->references(['payment_id'])->on('order');
            $table->foreign(['uuid'], 'payment_details_ibfk_1')->references(['uuid'])->on('order');
            $table->foreign(['payment_method_id'], 'payment_details_ibfk_2')->references(['id'])->on('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_details', function (Blueprint $table) {
            $table->dropForeign('payment_details_ibfk_1');
        });
    }
}
