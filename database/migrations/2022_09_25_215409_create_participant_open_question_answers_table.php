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
        Schema::create('participant_open_question_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id');
            $table->foreignId('open_question_id');
            $table->text('answer')->nullable();
            $table->timestamps();

            $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
            $table->foreign('open_question_id')->references('id')->on('open_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant_open_question_answers');
    }
};
