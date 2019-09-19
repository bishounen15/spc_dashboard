<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseIssuanceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('web_portal')->create('wi02', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('issuance_id');
            $table->string('item_code');
            $table->float('qty_issued',12,8);
            $table->float('conv_qty',12,8);

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
        Schema::connection('web_portal')->dropIfExists('wi02');
    }
}
