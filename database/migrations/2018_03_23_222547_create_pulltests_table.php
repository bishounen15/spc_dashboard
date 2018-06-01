<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePulltestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('spc')->create('pull_tests', function (Blueprint $table) {
            $table->increments('id');
            $table->String('Date');
            $table->String('Laminator');
            $table->String('Shift');
            $table->String('Recipe');
            $table->String('Glass');
            $table->String('ModuleID');
            $table->String('EVA');
            $table->String('Backsheet');
            $table->String('Location');
            $table->String('PTEG1');
            $table->String('PTEG2');
            $table->String('PTEG3');
            $table->String('PTEG4');
            $table->String('PTEG5');
            $table->String('PTEG6');
            $table->String('PTEG7');
            $table->String('PTEG8');
            $table->String('PTEG9');
            $table->String('PTEG10');
            $table->String('PTEGA');
            $table->String('PTEB1');
            $table->String('PTEB2');
            $table->String('PTEB3');
            $table->String('PTEB4');
            $table->String('PTEB5');
            $table->String('PTEB6');
            $table->String('PTEB7');
            $table->String('PTEB8');
            $table->String('PTEB9');
            $table->String('PTEB10');
            $table->String('PTEBA');
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
        Schema::connection('spc')->dropIfExists('pull_tests');
    }
}
