<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModuleUpdateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('trina')->create('solarph.module_update_logs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('Module_ID');
            $table->string('field_name');
            $table->string('old_value');
            $table->string('new_value');
            $table->integer('user_id');

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
        Schema::connection('trina')->dropIfExists('solarph.module_update_logs');
    }
}
