<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('assets')->create('tbl_general', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->string('brand');
            $table->string('model');
            $table->string('serial');
            $table->string('os');
            $table->string('host_name');
            $table->string('id_number');
            $table->string('name');
            $table->string('dept');
            $table->string('status');
            $table->string('proc');
            $table->string('ram');
            $table->string('hdd');
            $table->dateTime('dt_scanned')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('assets')->dropIfExists('tbl_general');
    }
}
