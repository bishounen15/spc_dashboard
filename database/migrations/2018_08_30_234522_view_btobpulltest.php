<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewBtobpulltest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('btobpulltest', function (Blueprint $table) {
            //
            $table->date('date')->default('1900-01-01');
        });
      
        DB::statement('CREATE VIEW view_btobpulltest AS SELECT DISTINCT(date) FROM btobpulltest ORDER BY date DESC Limit 30');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('btobpulltest', function (Blueprint $table) {
            //
            $table->dropColumn('date');
        });
        Schema::dropIfExists('view_btobpulltest');
    }
}
