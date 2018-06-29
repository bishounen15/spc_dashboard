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
        Schema::create('potting_quals', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('shift');
            $table->string('time');
            $table->string('pottantName');
            $table->string('jBoxName');
         //   $table->string('sealant');
            $table->double('pottantWeight');
            $table->integer('snapTime');
            $table->string('target');
            $table->string('qualRes');
            $table->string('crossSection');
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('potting_quals');
    }
}
