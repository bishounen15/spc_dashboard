<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddProdBuilt extends Migration
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
            $table->string('prodBuilt');
        });
        Schema::table('offlinematsoldering', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
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
