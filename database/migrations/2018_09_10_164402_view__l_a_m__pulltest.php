<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewLAMPulltest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('CREATE VIEW view_lam AS SELECT DISTINCT(date) FROM lams ORDER BY date DESC Limit 30');
        DB::statement('CREATE VIEW view_pulltests AS SELECT DISTINCT(date) FROM pull_tests ORDER BY date DESC Limit 30');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_lam');  
        Schema::dropIfExists('view_pulltests');  
    }
}
