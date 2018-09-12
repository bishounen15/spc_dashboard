<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSoftwareTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('assets')->create('tbl_software', function (Blueprint $table) {
            $table->increments('rowid');
            $table->integer('id');
            $table->string('install_date');
            $table->string('app_name');
            $table->string('version');
            $table->string('install_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('assets')->dropIfExists('tbl_software');
    }
}
