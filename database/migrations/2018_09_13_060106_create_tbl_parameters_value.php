<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblParametersValue extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
                $table->increments('id'); 
                $table->string('paramID')->comment = "Parameter ID";
                $table->string('targetVal')->comment = "Target Value";
                $table->string('indicatorID')->comment = "Indicator ID";
                $table->string('subProcessName')->comment = "Sub Process Name";
                $table->string('modelName')->comment = "Model Name";
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
        Schema::dropIfExists('parameters');
    }

}
