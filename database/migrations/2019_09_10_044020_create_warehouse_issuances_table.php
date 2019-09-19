<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseIssuancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('web_portal')->create('wi01', function (Blueprint $table) {
            $table->increments('id');

            $table->date('production_date');
            $table->string('production_line');
            $table->string('registration');
            $table->string('product_type');
            $table->string('requestor');
            $table->string('mits_number');
            
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
        Schema::connection('web_portal')->dropIfExists('wi01');
    }
}
