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
            $table->dateTime('date');
            $table->string('moduleID');
            $table->integer('L1');
            $table->integer('L2');
            $table->integer('L3');
            $table->integer('LDiff');
            $table->integer('S1');
            $table->integer('S2');
            $table->integer('S3');
            $table->integer('SDiff');
            $table->integer('D1');
            $table->integer('D2');
            $table->integer('DDiff');
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
