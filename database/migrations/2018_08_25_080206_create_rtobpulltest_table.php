<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRtobpulltestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rtobpulltest', function (Blueprint $table) {
            $table->increments('id');
            $table->String('employeeid');
            $table->String('Location');
            $table->String('process');
            $table->String('shift');
            $table->String('node');
            $table->String('supplier');
            $table->String('productBuilt');
            $table->String('remarks');
            $table->double('site1');
            $table->double('site2');
            $table->double('site3');
            $table->double('average');
            $table->date('date');
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
        Schema::dropIfExists('rtobpulltest');
    }
}
