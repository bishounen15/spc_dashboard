<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBOMInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('web_portal')->create('typ01', function (Blueprint $table) {
            $table->increments('ROWID');

            $table->string('PRODTYPE',25);
            $table->string('BOMCODE',25);
            $table->text('BOMDESC');
            $table->boolean('ACTIVE');

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
        Schema::connection('web_portal')->dropIfExists('typ01');
    }
}
