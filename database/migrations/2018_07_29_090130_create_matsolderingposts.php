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
            $table->string('EmployeeID');
            $table->string('Location'); 
            $table->string('Shift');
            $table->string('Supplier');
            $table->string('Node');
            $table->string('Remarks');
            $table->float('Temp1');
            $table->float('Temp2');
            $table->float('Temp3');
            $table->float('Average');
            $table->float('botTemp1');
            $table->float('botTemp2');
            $table->float('botTemp3');
            $table->float('botAverage');
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
