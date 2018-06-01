<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlashesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('spc')->create('flashes', function (Blueprint $table) {
            $table->increments('id');
            $table->String('Date');
            $table->String('Difference');
            $table->String('CalSerial');
            $table->String('Remarks');
            $table->String('Target');
            $table->String('Actual');
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
        Schema::connection('spc')->dropIfExists('flashes');
    }
}
