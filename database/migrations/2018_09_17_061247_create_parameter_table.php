<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParameterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
                $table->increments('id'); 
                $table->string('paramID');
                //$table->string('indicatorID')->comment = "Indicator";
                $table->string('subProcessName')->comment = "Critical Node";
                $table->string('BOMType')->comment = "BOM Type";
                $table->string('UOM')->comment = "UOM";
                $table->string('targetVal')->comment = "Target Value";
                $table->string('ULVal')->comment = "UL Value";
                $table->string('LLVal')->comment = "LL Value";
                $table->string('cellType')->comment = "Cell Type";
                $table->string('sealantType')->comment = "Sealant Type";
                $table->string('JBOXType')->comment = "JBOX Type";
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
        Schema::dropIfExists('parameters');
    }


}
