<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flashes', function (Blueprint $table) {
            $table->increments('id');
            $table->String('ModuleID');
            $table->String('InspTime');
            $table->String('ISC');
            $table->String('UOC');
            $table->String('IMPP');
            $table->String('UMPP');
            $table->String('PMPP');
            $table->String('ShuntResist');
            $table->String('FF');
            $table->String('BIN');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flashes');
    }
}
