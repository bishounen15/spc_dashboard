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
            $table->string('qualTime');
          //  $table->integer('qualTransID');
            $table->string('shift');
            $table->date('date');
            $table->double('beadWt');
            $table->string('jBox');
            $table->string('sealant');
            $table->double('target');
            //$table->string('materialPN');
            $table->double('cdaPressure');
            $table->integer('mainCDASupply');
            $table->integer('RAMCDA');
            $table->integer('downStream');
            $table->string('qualRes');
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
        Schema::dropIfExists('jbox_dis_wt_quals');
    }
}
