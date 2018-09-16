<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSubProcess extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subprocess', function (Blueprint $table) {
                $table->increments('id'); 
                $table->string('subProcessName')->comment = "Sub Process Name";
                $table->string('subProcessDesc')->comment = "Sub Process Description";
                $table->string('ProcessName')->comment = "Process Name";
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
        Schema::dropIfExists('subprocess');
    }

}
