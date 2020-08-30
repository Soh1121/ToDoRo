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
            $table->id()->primary();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('context_id')->references('id')->on('contexts');
            $table->dateTime('start_date');
            $table->dateTime('due_date');
            $table->unsignedInteger('term');
            $table->boolean('finished');
            $table->unsignedInteger('done');
            $table->time('timer');
            $table->foreign('repeat_id')->references('id')->on('repeats');
            $table->unsignedInteger('priority');
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
        Schema::dropIfExists('tasks');
    }
}
