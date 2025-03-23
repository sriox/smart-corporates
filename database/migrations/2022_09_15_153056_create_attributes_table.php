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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('dimension_id')->unsigned();
            $table->string('name', 400);
            $table->string('slug', 400);
            $table->string('description', 400);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('dimension_id')->references('id')->on('dimensions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributes');
    }
};
