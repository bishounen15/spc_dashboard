<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SetDefaultValuesFor4mFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection("yield")->table('yield_datas', function($table) {
            $table->integer('man')->default(0)->change();
            $table->integer('mac')->default(0)->change();
            $table->integer('mat')->default(0)->change();
            $table->integer('met')->default(0)->change();
            $table->integer('env')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::connection("yield")->table('yield_datas', function($table) {
            $table->integer('man')->change();
            $table->integer('mac')->change();
            $table->integer('mat')->change();
            $table->integer('met')->change();
            $table->integer('env')->change();
        });
    }
}
