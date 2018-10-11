<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFlashsetup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flashsetup', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('ProductType')->comment = "Product/Module Type";
            $table->string('SNno')->comment = "S/N No.";
            $table->string('Pmpp')->comment = "Pmpp(W)";
            $table->string('Vmpp')->comment = "Vmpp(V)";
            $table->string('Voc')->comment = "Voc(V)";
            $table->string('Impp')->comment = "Impp(A)";
            $table->string('Isc')->comment = "Isc(A)";
            $table->string('FF')->comment = "FF(%)";
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
        Schema::dropIfExists('flashsetup');
    }
}
