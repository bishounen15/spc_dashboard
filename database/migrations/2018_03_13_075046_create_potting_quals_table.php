<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePOttingQualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('spc')->create('potting_quals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shift');
            $table->dateTime('time');
            $table->string('pottantName');
            $table->string('jBoxName');
            $table->double('pottantWeight');
            $table->integer('snapTime');
            $table->string('crossSection');
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
        Schema::connection('spc')->dropIfExists('potting_quals');
    }
}
