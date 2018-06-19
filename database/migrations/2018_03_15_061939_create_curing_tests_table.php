<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuringTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curing_tests', function (Blueprint $table) {
            $table->increments('id');
          //  $table->string('qualTime');
            $table->string('shift');
            $table->string('serialNo');
            $table->date('date');
            $table->string('snapTime');
            $table->string('pottingTime');
            $table->string('condition'); 
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
        Schema::dropIfExists('curing_tests');
    }
}
