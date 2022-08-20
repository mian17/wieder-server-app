<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToUserRoleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_role_user', function (Blueprint $table) {
            $table->foreign(['user_role_id'], 'user_role_user_ibfk_2')->references(['id'])->on('user_role');
            $table->foreign(['user_uuid'], 'user_role_user_ibfk_1')->references(['uuid'])->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_role_user', function (Blueprint $table) {
            $table->dropForeign('user_role_user_ibfk_2');
            $table->dropForeign('user_role_user_ibfk_1');
        });
    }
}
