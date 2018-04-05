<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
                $table->increments('id'); 
                $table->string('Station');
                $table->string('Location');
                $table->string('Shift');
                $table->string('Supplier');
                $table->float('Temp');
                $table->integer('Site');
                $table->float('Pull Test');
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
        Schema::dropIfExists('posts');
    }
}
