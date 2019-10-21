<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLotTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('web_portal')->create('lt01', function (Blueprint $table) {
            $table->increments('id');

            $table->string('LOCNCODE');
            $table->integer('PRODLINE');
            $table->string('MACHINE');
            $table->string('SERIALNO');
            $table->datetime('TRXDATE')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('UIDTRANS');

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
        Schema::connection('web_portal')->dropIfExists('lt01');
    }
}
