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
        Schema::create('open_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id');
            $table->string('question', 2000);
            $table->string('description', 2000);
            $table->enum('type', ['text', 'words']);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('poll_id')->references('id')->on('polls')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('open_questions');
    }
};
