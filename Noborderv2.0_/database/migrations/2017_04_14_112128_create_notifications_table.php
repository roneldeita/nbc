<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id');
            $table->integer('type'); // 1 - new project, 2 - Project Update,  3 - New Contract , 4 - Contract Signed/ Approve, *5 - Project Now On Progress // 11 - new proposal
            $table->integer('from'); 
            $table->integer('to');
            $table->text('content'); // which is compose of json 
            $table->integer('seen'); // 1 - yes , 2 - no
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
        Schema::dropIfExists('notifications');
    }
}
