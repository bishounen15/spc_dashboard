<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrameQualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('spc')->create('frame_quals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qualTransID')->nullable();
            $table->string('shift');
            $table->date('date');
            $table->string('qualTime');
            $table->string('serialNo');
            $table->double('L1woSealantWt');
            $table->double('L1wSealantWt');
            $table->double('L2woSealantWt');
            $table->double('L2wSealantWt');
            $table->double('S1woSealantWt');
            $table->double('S1wSealantWt');
            $table->double('S2woSealantWt');
            $table->double('S2wSealantWt');
            $table->string('L1diff');
            $table->string('L2diff');
            $table->string('S1diff');
            $table->string('S2diff');
            $table->double('weight');
            $table->double('beadScale');
            $table->string('facilitySupply');
            $table->double('mainPressure');
            $table->string('paramID')->nullable();
            $table->double('TargetParam')->nullable();
            $table->string('qualResult')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::connection('spc')->dropIfExists('frame_quals');
    }
}
