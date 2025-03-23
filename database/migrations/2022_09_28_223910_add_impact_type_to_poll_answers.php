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
        Schema::table('poll_answers', function (Blueprint $table) {
            $table->string('impact_type', 100)->nullable()->after('value')->comment('Positive, negative or neutral');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('poll_answers', function (Blueprint $table) {
            $table->dropColumn('impact_type');
        });
    }
};
