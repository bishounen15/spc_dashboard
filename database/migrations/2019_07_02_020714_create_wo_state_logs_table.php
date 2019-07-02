<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWoStateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('trina')->create('solarph.wo_state_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('Workorder_ID');
            $table->string('Workorder_vertion');
            $table->string('old_state');
            $table->string('new_state');
            $table->string('remarks');
            $table->string('user_id');

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
        Schema::connection('trina')->dropIfExists('solarph.wo_state_logs');
    }
}
