<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActivityColumnToProductionSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('planning')->table('production_schedules', function (Blueprint $table) {
            $table->string('activity')->nullable()->after('weekday');
            $table->string('cells')->nullable()->after('activity');
            $table->string('backsheets')->nullable()->after('cells');
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
        Schema::connection('planning')->table('production_schedules', function (Blueprint $table) {
            $table->dropColumn('activity');
            $table->dropColumn('cells');
            $table->dropColumn('backsheets');
        });
    }
}
