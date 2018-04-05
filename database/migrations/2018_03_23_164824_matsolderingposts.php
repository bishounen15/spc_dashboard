<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MatsolderingPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matsolderingposts', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('Station');
            $table->string('Location');
            $table->string('Shift');
            $table->string('Supplier');
            $table->string('Node');
            $table->integer('Site1');
            $table->float('Temp1');
            $table->integer('Site2');
            $table->float('Temp2');
            $table->integer('Site3');
            $table->float('Temp3');
            $table->float('Average');
            $table->string('Remarks');
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
        Schema::drop('matsolderingposts');
    }
}
