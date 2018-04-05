<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJboxDisWtQualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jbox_dis_wt_quals', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('qualTransID');
            $table->string('shift');
            $table->dateTime('date');
            $table->double('beadWt');
            $table->string('materialPN');
            $table->double('cdaPressure');
            $table->string('JBox');
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
        Schema::dropIfExists('jbox_dis_wt_quals');
    }
}
