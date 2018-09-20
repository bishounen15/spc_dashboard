<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDTCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('proddt')->create('categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('code');
            $table->string('descr');
            $table->string('color_scheme');

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
        Schema::connection('proddt')->dropIfExists('categories');
    }
}
