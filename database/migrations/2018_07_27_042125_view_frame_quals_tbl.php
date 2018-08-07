<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewFrameQualsTbl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     
        DB::statement('CREATE VIEW view_frameQuals AS SELECT DISTINCT(date) FROM frame_quals ORDER BY date DESC Limit 30');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('frame_quals', function (Blueprint $table) {
            //
        });
    }
}
