<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFrameSqBwsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('frame_sq_bws', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qualTransID');
            $table->string('shift');
            $table->date('date');
            $table->string('qualTime');
            $table->integer('cellCount');
            $table->string('moduleID');
            $table->double('L1');
            $table->double('L2');
            $table->double('L3');
            $table->double('LDiff');
            $table->double('S1');
            $table->double('S2');
            $table->double('S3');
            $table->double('SDiff');
            $table->double('D1');
            $table->double('D2');
            $table->double('DDiff');
            $table->string('remarks');
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
        Schema::dropIfExists('frame_sq_bws');
    }
}
