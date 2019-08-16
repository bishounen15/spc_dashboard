<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProdLineToYield extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('yield')->table('yield_datas', function (Blueprint $table) {
            $table->string('production_line')->nullable()->after('shift');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::connection('yield')->table('yield_datas', function (Blueprint $table) {
            $table->dropColumn('production_line');
        });
    }
}
