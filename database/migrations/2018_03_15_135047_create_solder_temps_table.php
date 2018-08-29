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
        Schema::connection('spc')->create('solder_temps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transID');
            $table->string('shift');
            $table->string('qualTime');
            $table->date('date');
            $table->double('tempBefAdj1');
            $table->double('tempAftAdj1');
            $table->double('tempBefAdj2');
            $table->double('tempAftAdj2');
            $table->double('tempBefAdj3');
            $table->double('tempAftAdj3');
            $table->double('tempAftAdjAve');
            $table->double('tempBefAdjAve');
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
        Schema::connection('spc')->dropIfExists('solder_temps');
    }
}
