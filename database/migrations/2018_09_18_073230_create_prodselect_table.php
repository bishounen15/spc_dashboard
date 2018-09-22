<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdselectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prodselect', function (Blueprint $table) {
            $table->increments('id');
            $table->string('productName')->comment="Product Name";
            $table->string('ProcessName')->comment="Process";
            $table->string('remarks')->nullable()->comment="remarks";
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
        Schema::dropIfExists('prodselect');
    }
}
