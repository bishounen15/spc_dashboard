<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStringersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stringers', function (Blueprint $table) {
            $table->increments('id');
            $table->String('Date');
            $table->String('Stringer');
            $table->String('Shift');
            $table->String('Cell');
            $table->String('Ribbon');
            $table->String('Station');
            $table->String('Side');
            $table->String('CellNo');
            $table->String('Location');
            $table->String('PeelTest');
            $table->String('Criteria');
            $table->String('Remarks');
            $table->String('Site1');
            $table->String('Site2');
            $table->String('Site3');
            $table->String('Site4');
            $table->String('Site5');
            $table->String('Site6');
            $table->String('Site7');
            $table->String('Site8');
            $table->String('Site9');
            $table->String('Site10');
            $table->String('Site11');
            $table->String('Site12');
            $table->String('Site13');
            $table->String('Site14');
            $table->String('Site15');
            $table->String('Site16');
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
        Schema::dropIfExists('stringers');
    }
}
