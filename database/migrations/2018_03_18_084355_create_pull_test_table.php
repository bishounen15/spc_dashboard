<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePullTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('spc')->create('matrix_pull_tests', function (Blueprint $table) {
                $table->increments('id'); 
                $table->string('Station');
                $table->string('Location');
                $table->string('Shift');
                $table->string('Node');
                $table->string('Supplier');
                $table->integer('Site1');
                $table->float('PullTest1');
                $table->integer('Site2');
                $table->float('PullTest2');
                $table->integer('Site3');
                $table->float('PullTest3');
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
        Schema::connection('spc')->dropIfExists('matrix_pull_tests');
    }
}
