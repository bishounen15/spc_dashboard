<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOBAsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('trina')->create('solarph.oba', function (Blueprint $table) {
            $table->increments('id');

            $table->string('Module_ID');
            $table->string('Carton_no');
            $table->string('Judgement');
            $table->string('Remarks');

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
        Schema::connection('trina')->dropIfExists('solarph.oba');
    }
}
