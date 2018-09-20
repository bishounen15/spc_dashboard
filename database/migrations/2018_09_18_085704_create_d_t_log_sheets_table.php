<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDTLogSheetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('proddt')->create('log_sheets', function (Blueprint $table) {
            $table->increments('id');

            $table->date('date');
            $table->string('shift');
            $table->integer('station_id');
            $table->time('start');
            $table->time('end');
            $table->float('duration',8,2);
            $table->integer('downtime_id');
            $table->text('remarks');

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
        Schema::connection('proddt')->dropIfExists('log_sheets');
    }
}
