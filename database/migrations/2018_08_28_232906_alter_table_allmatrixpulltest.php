<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAllmatrixpulltest extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mat_solderings', function (Blueprint $table) {
            //
            $table->date('date')->default('1900-01-01');
        });
      
        Schema::table('rtobpulltest', function (Blueprint $table) {
            //
            $table->date('date');
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
    }
}
