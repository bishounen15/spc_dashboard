<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRtobpullTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rtobpull', function (Blueprint $table) {
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
            $table->String('pulltest1');
            $table->String('pulltest2');
            $table->String('pulltest3');
            $table->String('average');
            $table->String('twosite1');
            $table->String('twosite2');
            $table->String('twosite3');
            $table->String('twopulltest1');
            $table->String('twopulltest2');
            $table->String('twopulltest3');
            $table->String('twoaverage');
            $table->String('botsite1');
            $table->String('botsite2');
            $table->String('botsite3');
            $table->String('botpulltest1');
            $table->String('botpulltest2');
            $table->String('botpulltest3');
            $table->String('botaverage');
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
        Schema::dropIfExists('rtobpull');
    }
}
