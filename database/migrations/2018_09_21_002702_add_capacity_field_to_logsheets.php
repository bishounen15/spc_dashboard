<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCapacityFieldToLogsheets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('proddt')->table('log_sheets', function (Blueprint $table) {
            $table->boolean('capacity')->after('station_id');
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
        Schema::connection('proddt')->table('log_sheets', function (Blueprint $table) {
            $table->dropColumn('capacity');
        });
    }
}
