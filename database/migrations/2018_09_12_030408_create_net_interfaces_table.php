<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNetInterfacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('assets')->create('tbl_network', function (Blueprint $table) {
            $table->increments('rowid');
            $table->integer('id');
            $table->string('ip');
            $table->string('mac');
            $table->string('name');
            $table->string('descr');
            $table->string('interface');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('assets')->dropIfExists('tbl_network');
    }
}
