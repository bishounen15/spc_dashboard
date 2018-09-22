<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMatsolderingposts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('mat_solderings', function (Blueprint $table) {
            $table->increments('id');
            $table->String('employeeid');
            $table->String('Location');
            $table->String('process');
            $table->String('shift');
            $table->String('node');
            $table->String('supplier');
            $table->String('productBuilt');
            $table->String('remarks');
            $table->double('temp1');
            $table->double('temp2');
            $table->double('temp3');
            $table->double('average');
       //     $table->date('date');
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
        //
        Schema::dropIfExists('mat_solderings');
    }
}
