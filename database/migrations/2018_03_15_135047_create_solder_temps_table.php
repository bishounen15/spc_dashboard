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
            $table->dateTime('date');
            $table->integer('tempBefAdj');
            $table->integer('tempAftAdj');
            $table->string('remarks');
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
