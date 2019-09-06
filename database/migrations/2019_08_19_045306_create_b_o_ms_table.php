<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBOMsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('web_portal')->create('bm01', function (Blueprint $table) {
            $table->increments('id');

            $table->string('product_type');
            $table->string('category');
            $table->string('item_class');
            $table->float('bom_qty', 8, 5);
            $table->integer('bom_index');

            $table->timestamps();
        });

        Schema::connection('web_portal')->create('bm02', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('bom_id');
            $table->string('item_code');

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
        Schema::connection('web_portal')->dropIfExists('bm01');
        Schema::connection('web_portal')->dropIfExists('bm02');
    }
}
