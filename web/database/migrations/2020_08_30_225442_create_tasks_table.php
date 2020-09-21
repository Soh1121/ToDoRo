<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('context_id');
            $table->dateTime('start_date');
            $table->dateTime('due_date');
            $table->unsignedInteger('term');
            $table->boolean('finished');
            $table->unsignedInteger('done');
            $table->time('timer');
            $table->unsignedBigInteger('repeat_id');
            $table->unsignedInteger('priority');
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('context_id')->references('id')->on('contexts');
            $table->foreign('repeat_id')->references('id')->on('repeats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
