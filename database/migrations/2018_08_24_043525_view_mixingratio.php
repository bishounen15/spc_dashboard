<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewMixingratio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        DB::statement('CREATE VIEW view_mixingratioby30 AS SELECT DISTINCT(date) FROM pottant_quals ORDER BY date DESC Limit 30');
        DB::statement('CREATE VIEW view_mixingratioby7 AS SELECT DISTINCT(date) FROM pottant_quals ORDER BY date DESC Limit 7');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
