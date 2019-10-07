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
            $table->string('uofm_base');
            $table->string('uofm_issue');
            $table->float('conv_issue',15,5);
            $table->float('base_qty',15,5);
            $table->float('issue_qty',15,5);
            $table->string('remarks')->nullable();

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
