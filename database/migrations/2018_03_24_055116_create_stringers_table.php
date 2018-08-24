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
            $table->Date('Date');
            $table->String('Stringer');
            $table->String('Shift');
            $table->String('Cell');
            $table->String('Ribbon');
            $table->String('Side');
            $table->String('CellNo');
            $table->String('Site');
            $table->String('Location');
            $table->String('PeelTest');
            $table->String('Criteria');
            $table->String('Remarks');
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
