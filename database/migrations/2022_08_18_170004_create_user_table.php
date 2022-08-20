<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->char('uuid', 36)->default(DB::raw('(UUID())'))->primary();
            $table->string('username');
            $table->string('password');
            $table->string('email')->unique();
            $table->string('phone_number')->unique();
            $table->string('name');
            $table->date('birth_date');
            $table->tinyInteger('gender');
            $table->string('address');
            $table->integer('reward_points')->default(0);
            $table->string('avatar')->default('\\\'/img/avatar/default-avatar.png\\\'');
            $table->timestamp('last_sign_in')->useCurrentOnUpdate()->useCurrent();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
