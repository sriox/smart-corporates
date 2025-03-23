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
        Schema::create('poll_answers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('poll_id')->unsigned();
            $table->string('name', 100);
            $table->float('value');
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
        Schema::dropIfExists('poll_answers');
    }
};
