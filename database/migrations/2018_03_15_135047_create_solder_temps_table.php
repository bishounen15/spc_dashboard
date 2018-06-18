<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolderTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solder_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transID');
            $table->string('shift');
            $table->string('qualTime');
            $table->date('date');
            $table->integer('tempBefAdj1');
            $table->integer('tempAftAdj1');
            $table->integer('tempBefAdj2');
            $table->integer('tempAftAdj2');
            $table->integer('tempBefAdj3');
            $table->integer('tempAftAdj3');
            $table->integer('tempAftAdjAve');
            $table->integer('tempBefAdjAve');
            $table->string('target');
            $table->string('result');
            $table->string('remarks')->nullable();
            $table->string('jBox');
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
        Schema::dropIfExists('solder_temps');
    }
}
