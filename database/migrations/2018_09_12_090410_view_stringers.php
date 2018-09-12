<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ViewStringers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   
    public function up()
    {
        //
        DB::statement('CREATE VIEW view_stringers AS SELECT DISTINCT(Date) FROM stringers ORDER BY Date DESC Limit 30');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_stringers');  
    }
}
