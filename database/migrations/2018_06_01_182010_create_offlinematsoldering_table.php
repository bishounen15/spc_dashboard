<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfflinematsolderingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        

        Schema::create('offlinematsoldering', function (Blueprint $table) {
                $table->increments('id');
                $table->String('employeeid');
                $table->String('location');
                $table->String('shift');
                $table->String('node');
                $table->String('supplier');
                $table->String('temp1');
                $table->String('temp2');
                $table->String('temp3');
                $table->String('remarks');
                $table->String('average');
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
        // Schema::dropIfExists('offlinematsoldering');
        Schema::dropIfExists('offlinematsoldering');
    }
}
