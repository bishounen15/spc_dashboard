<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialLotDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('web_portal')->create('ml01', function (Blueprint $table) {
            $table->increments('id');

            $table->string('parent_lot');
            $table->string('child_lot');

            $table->timestamps();

            $table->unique(['parent_lot','child_lot']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('web_portal')->dropIfExists('ml01');
    }
}
