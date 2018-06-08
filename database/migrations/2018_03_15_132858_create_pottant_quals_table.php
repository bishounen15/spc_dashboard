<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePottantQualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('spc')->create('pottant_quals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qualTransID');
            $table->string('shift');
            $table->dateTime('date');
            $table->integer('sampleCount');
            $table->double('befDispenseWtA');
            $table->double('befDispenseWtB');
            $table->double('dispensedWtA');
            $table->double('dispensedWtB');
            $table->double('weightA');
            $table->double('weightB');
            $table->double('totalWt');
            $table->double('targetParam')->nullable();
            $table->integer('ratio');

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
        Schema::connection('spc')->dropIfExists('pottant_quals');
    }
}
