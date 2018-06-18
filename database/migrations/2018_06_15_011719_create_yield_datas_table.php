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
            $table->datetime('from');
            $table->datetime('to');
            $table->string('build');
            $table->decimal('target');
            $table->integer('product_size');
            $table->integer('input_cell');
            $table->integer('input_mod');

            $table->integer('inprocess_cell');
            $table->integer('ccd_cell');
            $table->integer('visualdefect_cell');
            $table->integer('cell_defect');
            $table->integer('cell_class_b');
            $table->integer('cell_class_c');

            $table->integer('str_produced');
            $table->integer('str_defect');

            $table->integer('el1_inspected');
            $table->integer('el1_defect');

            $table->integer('be_inspected');
            $table->integer('be_defect');
            $table->integer('be_class_b');
            $table->integer('be_class_c');

            $table->integer('el2_class_a');
            $table->integer('el2_defect');
            $table->integer('el2_class_b');
            $table->integer('el2_class_c');
            $table->integer('el2_low_power');

            $table->integer('man');
            $table->integer('mac');
            $table->integer('mat');
            $table->integer('met');
            $table->integer('env');
            $table->integer('total_4m');
            $table->integer('total_defect');

            $table->float('py');
            $table->float('ey');
            $table->float('srr');
            $table->float('mrr');

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
        Schema::connection('yield')->dropIfExists('yield_datas');
    }
}
