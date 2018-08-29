<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableSqBw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('spc')->table('frame_sq_bws', function (Blueprint $table) {
            //
             $table->string('qualRes');
             $table->double('target');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('spc')->table('frame_sq_bws', function (Blueprint $table) {
            //
            $table->dropColumn(['qualRes','target']);
        });
    }
}
