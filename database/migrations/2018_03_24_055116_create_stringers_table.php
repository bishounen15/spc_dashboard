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
        Schema::connection('spc')->create('stringers', function (Blueprint $table) {
            $table->increments('id');
            $table->String('Date');
            $table->String('Laminator');
            $table->String('Shift');
            $table->String('Cell');
            $table->String('Ribbon');
            $table->String('Station');
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
        Schema::connection('spc')->dropIfExists('stringers');
    }
}
