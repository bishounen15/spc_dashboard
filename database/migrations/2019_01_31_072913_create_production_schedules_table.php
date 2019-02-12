<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('planning')->create('production_schedules', function (Blueprint $table) {
            // $table->charset = 'latin1';
            // $table->collation = 'latin1_swedish_ci';

            $table->increments('id');

            $table->date('production_date');
            $table->string('work_week');
            $table->string('weekday');
            $table->string('shifts');

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
        Schema::connection('planning')->dropIfExists('production_schedules');
    }
}
