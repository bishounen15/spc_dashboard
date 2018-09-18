<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDTTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('proddt')->create('dt_types', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('machine_id');
            $table->integer('category_id');
            $table->string('downtime');

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
        Schema::connection('proddt')->dropIfExists('dt_types');
    }
}
