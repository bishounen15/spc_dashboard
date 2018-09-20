<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeCapacityFieldToMachineId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('proddt')->table('stations', function (Blueprint $table) {
            $table->integer('machine_id')->after('descr');
            $table->dropColumn('capacity');
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
        Schema::connection('proddt')->table('users', function (Blueprint $table) {
            $table->integer('capacity')->after('descr');
            $table->dropColumn('machine_id');
        });
    }
}
