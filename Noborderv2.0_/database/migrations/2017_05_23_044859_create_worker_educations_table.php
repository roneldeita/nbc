<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkerEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_educations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('worker_id');
            $table->text('school');
            $table->text('qualification');
            $table->text('field');
            $table->string('from');
            $table->string('to');
            $table->text('description');
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
        Schema::dropIfExists('worker_educations');
    }
}
