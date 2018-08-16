<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeSuppliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('osi')->create('office_supplies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->string('description');
            $table->integer('category_id');
            $table->integer('uofm_id');
            $table->float('unit_cost');
            $table->integer('stock_limit');
            $table->integer('current_stock');
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
        Schema::connection('osi')->dropIfExists('office_supplies');
    }
}
