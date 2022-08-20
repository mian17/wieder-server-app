<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role_user', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->char('user_uuid', 36)->index('user_id');
            $table->tinyInteger('user_role_id')->index('user_role_id');
            $table->unique(['user_role_id', 'user_uuid']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role_user');
    }
}
