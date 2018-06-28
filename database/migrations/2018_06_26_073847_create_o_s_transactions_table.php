<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOSTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('osi')->create('transactions', function (Blueprint $table) {
            $table->increments('id');

            $table->string('control_no');
            $table->date('date');
            $table->string('type');
            $table->string('status');
            $table->text('remarks');

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
        Schema::connection('osi')->dropIfExists('transactions');
    }
}
