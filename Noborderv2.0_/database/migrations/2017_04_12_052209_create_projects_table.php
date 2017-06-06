<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('skill_category_id');
            $table->integer('client_id');
            $table->integer('coordinator_id');
            $table->string('name');
            $table->text('description');
            //$table->decimal('budget',10,2)->nullable();
            $table->text('budget_info');
            $table->string('timeline');
            $table->integer('status'); // 1 - for draft, 2 - published, 3 - pre-screening, 4 - contract signing, 5 - in progress, 6 - closed
            $table->text('deliverables');
            $table->text('terms_condition');
            $table->text('skills'); // set of ids in json form
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
        Schema::dropIfExists('projects');
    }
}
