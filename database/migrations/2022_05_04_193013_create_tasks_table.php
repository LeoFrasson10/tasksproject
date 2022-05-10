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
            $table->string('description');
            $table->dateTime('datetime_deadline');
            $table->unsignedBigInteger('collaborator_id');
            $table->enum('priority', ['Baixa', 'Média', 'Alta']);
            $table->dateTime('datetime_completed')->nullable();
            $table->foreign('collaborator_id')->references('id')->on('collaborators');
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
