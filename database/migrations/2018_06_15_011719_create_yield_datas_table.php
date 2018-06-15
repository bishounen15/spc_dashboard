<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYieldDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('yield')->create('yield_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('team');
            $table->date('date');
            $table->string('shift');
            $table->datetime('last_extract');
            $table->string('build');
            $table->decimal('target');
            $table->integer('product_size');
            $table->integer('input_cell');
            $table->integer('input_mod');
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
        Schema::connection('spc')->dropIfExists('yield_datas');
    }
}
