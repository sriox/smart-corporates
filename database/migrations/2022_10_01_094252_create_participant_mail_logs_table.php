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
        Schema::create('participant_mail_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('participant_id');
            $table->string('event', 400);
            $table->longText('description')->nullable();
            $table->boolean('valid')->default(false);
            $table->timestamps();

            $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participant_mail_logs');
    }
};
