<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMESAdditionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('web_portal')->create('mes02', function (Blueprint $table) {
            $table->increments('ROWID');

            $table->string('SERIALNO');
            $table->string('LOCNCODE');
            $table->string('INFOTYPE');
            $table->string('FIELDNAME');
            $table->string('FIELDVALUE');

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
        Schema::connection('web_portal')->dropIfExists('mes02');
    }
}
