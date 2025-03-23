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
        Schema::create('color_scales', function (Blueprint $table) {
            $table->id();
            $table->string('type', 20)->comment('tipo de escala de medición');
            $table->double('min_val', 18, 2)->default(0);
            $table->double('max_val', 18, 2)->default(0);
            $table->string('color', 20);
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
        Schema::dropIfExists('color_scales');
    }
};
