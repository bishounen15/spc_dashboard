<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBtobpulltestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('btobpulltest', function (Blueprint $table) {
            $table->increments('id');
            $table->String('employeeid');
            $table->String('location');
            $table->String('shift');
            $table->String('node');
            $table->String('supplier');
            $table->String('remarks');
            $table->String('site1');
            $table->String('site2');
            $table->String('site3');
            $table->String('average');
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
        Schema::dropIfExists('btobpulltest');
    }
}
