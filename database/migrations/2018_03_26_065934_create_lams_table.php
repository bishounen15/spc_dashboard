<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Lams', function (Blueprint $table) {
            $table->increments('id');
            $table->String('Date');
            $table->String('Laminator');
            $table->String('Shift');
            $table->String('Recipe');
            $table->String('Glass');
            $table->String('ModuleID');
            $table->String('EVA');
            $table->String('Backsheet');
            $table->String('Location');
            $table->String('LXM1');
            $table->String('LXM2');
            $table->String('LXM3');
            $table->String('LXM4');
            $table->String('LXM5');
            $table->String('LXM6');
            $table->String('LXM7');
            $table->String('LXM8');
            $table->String('LXM9');
            $table->String('LXM10');
            $table->String('LXM11');
            $table->String('LXM12');
            $table->String('LXM13');
            $table->String('LXM14');
            $table->String('LXM15');
            $table->String('LXM16');
            $table->String('LXMA');
            $table->String('RelGel1');
            $table->String('RelGel2');
            $table->String('RelGel3');
            $table->String('RelGel4');
            $table->String('RelGel5');
            $table->String('RelGel6');
            $table->String('RelGel7');
            $table->String('RelGel8');
            $table->String('RelGel9');
            $table->String('RelGel10');
            $table->String('RelGel11');
            $table->String('RelGel12');
            $table->String('RelGel13');
            $table->String('RelGel14');
            $table->String('RelGel15');
            $table->String('RelGel16');
            $table->String('RelGelA');
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
        Schema::dropIfExists('lams');
    }
}
