<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('planning')->create('shifts', function (Blueprint $table) {
            $table->increments('id');

            $table->string('code');
            $table->string('descr');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('overday');
            $table->float('duration',8,2);

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
        Schema::connection('planning')->dropIfExists('shifts');
    }
}
