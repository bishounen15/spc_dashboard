<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionScheduleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('planning')->create('production_schedule_products', function (Blueprint $table) {
            $table->charset = 'latin1';
            $table->collation = 'latin1_swedish_ci';
            
            $table->increments('id');

            $table->integer('schedule_id');
            $table->string('model_name');
            $table->string('production_line');
            $table->integer('qty');
            $table->string('cell');
            $table->string('backsheet');

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
        Schema::connection('planning')->dropIfExists('production_schedule_products');
    }
}
