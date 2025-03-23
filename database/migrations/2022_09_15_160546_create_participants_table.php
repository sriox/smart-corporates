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
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id');
            $table->foreignId('poll_instance_id');
            $table->string('code', 36)->nullable()->comment('Codigo de verificacion de presentacion de encuesta');
            $table->dateTime('start_at')->nullable();
            $table->dateTime('finish_at')->nullable();
            $table->dateTime('policy_accepted_at')->nullable();
            $table->foreignId('age_range_id')->nullable();
            $table->foreignId('gender_id')->nullable();
            $table->foreignId('service_time_range_id')->nullable();
            $table->foreignId('company_level_id')->nullable();
            $table->foreignId('area_id')->nullable();
            $table->foreignId('division_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('person_id')->references('id')->on('people')->onDelete('cascade');
            $table->foreign('poll_instance_id')->references('id')->on('poll_instances')->onDelete('cascade');
            $table->foreign('age_range_id')->references('id')->on('age_ranges')->onDelete('cascade');
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
            $table->foreign('service_time_range_id')->references('id')->on('service_time_ranges')->onDelete('cascade');
            $table->foreign('company_level_id')->references('id')->on('company_levels')->onDelete('cascade');
            $table->foreign('area_id')->references('id')->on('areas')->onDelete('cascade');
            $table->foreign('division_id')->references('id')->on('divisions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('participants');
    }
};
