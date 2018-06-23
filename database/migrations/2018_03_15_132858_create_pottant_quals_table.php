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
        Schema::create('pottant_quals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qualTransID');
            $table->string('shift');
            $table->date('date');
            $table->time('qualTime');
            $table->integer('sampleCount')->nullable();
            $table->double('befDispenseWtA');
            $table->double('befDispenseWtB');
            $table->double('dispensedWtA');
            $table->double('dispensedWtB');
            $table->double('weightA');
            $table->double('weightB');
            $table->double('totalWt');
            $table->double('targetWt');
            $table->double('ratioVal');
            $table->double('ratioTargetS');
            $table->double('ratioTargetE');
            $table->string('qualRes');
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
        Schema::dropIfExists('pottant_quals');
    }
}
