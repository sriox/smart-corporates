<?php

use App\Models\Company\Area;
use App\Models\Company\Division;
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
        Schema::table('divisions', function (Blueprint $table) {
            $table->foreignId('company_id')->nullable()->after('id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });

        $areas = Area::all()->toArray();
        $areas = array_column($areas, 'company_id', 'id');
        foreach (Division::all() as $division) {
            $division->company_id = $areas[$division->area_id];
            $division->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('divisions', function (Blueprint $table) {
            $table->dropForeign('divisions_company_id_foreign');
            $table->dropColumn('company_id');
        });
    }
};
