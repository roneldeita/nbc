<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account_id')->nullable(); // 8 digits
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('verification')->nullable();
            $table->integer('verified');
            $table->integer('online')->nullable();
            $table->integer('role')->nullable(); // 1 - client , 2 - worker , 3 - coordinator
            $table->string('avatar')->nullable();
            $table->string('background')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
