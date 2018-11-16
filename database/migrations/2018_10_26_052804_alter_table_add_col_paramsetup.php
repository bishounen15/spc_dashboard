<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddColParamsetup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('parameters', function (Blueprint $table) {
            //
             $table->string('frameType')->default('NA')->comment = "Frame Type";
             $table->double('CL')->default('0')->comment = "CL";
             $table->double('UCL')->default('0')->comment = "UCL";
             $table->double('LCL')->default('0')->comment = "LCL";
        });
    }

    /**
     * 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('parameters', function (Blueprint $table) {
            //
             $table->dropColumn('frameType');
             $table->dropColumn('CL');
             $table->dropColumn('UCL');
             $table->dropColumn('LCL');
        });
    }
}
