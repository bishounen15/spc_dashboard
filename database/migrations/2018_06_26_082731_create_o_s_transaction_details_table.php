<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOSTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('osi')->create('transaction_details', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('transaction_id');
            $table->integer('item_id');
            $table->integer('qty');
            $table->float('unit_cost');
            $table->float('total_cost');

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
        Schema::connection('osi')->dropIfExists('transaction_details');
    }
}
