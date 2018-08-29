<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewFramesqbw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::connection('spc')->statement('CREATE VIEW view_framesqbw AS SELECT DISTINCT(date) FROM frame_sq_bws ORDER BY date DESC Limit 30');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::connection('spc')->dropIfExists('view_framesqbw');
    }
}
