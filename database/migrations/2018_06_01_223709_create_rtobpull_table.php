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
        Schema::connection('spc')->create('rtobpull', function (Blueprint $table) {
            $table->increments('id');
            $table->String('station');
            $table->String('location');
            $table->String('shift');
            $table->String('node');
            $table->String('supplier');
            $table->String('site1');
            $table->String('pulltest1');
            $table->String('site2');
            $table->String('pulltest2');
            $table->String('site3');
            $table->String('pulltest3');
            $table->String('remarks');
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
        Schema::connection('spc')->dropIfExists('rtobpull');
    }
}
