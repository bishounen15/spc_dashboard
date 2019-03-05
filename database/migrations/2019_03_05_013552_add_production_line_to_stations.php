<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductionLineToStations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('proddt')->table('stations', function (Blueprint $table) {
            $table->integer('production_line')->after('machine_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::connection('proddt')->table('stations', function (Blueprint $table) {
            $table->dropColumn('production_line');
        });
    }
}
