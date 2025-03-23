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
        Schema::create('participant_poll_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id');
            $table->foreignId('question_id');
            $table->foreignId('poll_answer_id');
            $table->timestamps();

            $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('cascade');
            $table->foreign('poll_answer_id')->references('id')->on('poll_answers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant_poll_answers');
    }
};
