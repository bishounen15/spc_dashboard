<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLamTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mfg')->create('lam_transaction_details', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('trx_id');
            $table->string('serial_no');
            $table->string('location');
            $table->datetime('date_scanned');

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
        Schema::connection('mfg')->dropIfExists('lam_transaction_details');
    }
}
