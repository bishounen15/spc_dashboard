<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePulltestegsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('spc')->create('pull_test_egs', function (Blueprint $table) {
            $table->increments('id');
            $table->String('Date');
            $table->String('Laminator');
            $table->String('PullTest');
            $table->String('PeelStrength');
            $table->String('UCL');
            $table->String('LCL');
            $table->String('AVE');
            $table->String('Target');
            $table->String('CL');
            $table->String('USL');
            $table->String('LSL');
            $table->String('Sgmaplus1');
            $table->String('Sgmaplus2');
            $table->String('Sgmamin1');
            $table->String('Sgmamin2');
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
        Schema::connection('spc')->dropIfExists('pull_test_egs');
    }
}
