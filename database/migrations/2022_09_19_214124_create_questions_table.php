<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('attribute_id')->unsigned()->nullable();
            $table->bigInteger('poll_id')->unsigned();
            $table->bigInteger('question_group_id')->unsigned()->nullable();
            $table->string('question', 2000);
            $table->string('description', 2000)->nullable();
            $table->integer('order');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
            $table->foreign('question_group_id')->references('id')->on('question_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
