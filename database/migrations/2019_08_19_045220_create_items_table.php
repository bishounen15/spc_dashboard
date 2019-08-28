<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('web_portal')->create('im01', function (Blueprint $table) {
            $table->increments('id');

            $table->string('item_code');
            $table->string('item_desc');
            $table->string('item_class');
            $table->string('specs_01')->nullable();
            $table->string('specs_02')->nullable();
            $table->string('specs_03')->nullable();
            $table->string('specs_04')->nullable();
            $table->string('specs_05')->nullable();
            $table->string('specs_06')->nullable();
            $table->string('specs_07')->nullable();
            $table->string('specs_08')->nullable();
            $table->string('specs_09')->nullable();
            $table->string('specs_10')->nullable();
            $table->string('uofm_base')->nullable();
            $table->string('uofm_rcvd')->nullable();
            $table->string('uofm_issue')->nullable();

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
        Schema::connection('web_portal')->dropIfExists('im01');
    }
}
