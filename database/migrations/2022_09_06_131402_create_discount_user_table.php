<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discount_user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('user_uuid', 36)->index('user_uuid');
            $table->bigInteger('discount_id')->index('discount_id');


        });

        Schema::table('discount_user', function (Blueprint $table) {
            $table->foreign(['user_uuid'], 'discount_user_ibfk_1')->references(['uuid'])->on('user');
            $table->foreign(['discount_id'], 'discount_user_ibfk_2')->references('id')->on('discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discount_user');
    }
};
