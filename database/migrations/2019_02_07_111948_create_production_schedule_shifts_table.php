<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionScheduleShiftsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('planning')->create('production_schedule_shifts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('schedule_id');
            $table->integer('shift_id');

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
        Schema::connection('planning')->dropIfExists('production_schedule_shifts');
    }
}
