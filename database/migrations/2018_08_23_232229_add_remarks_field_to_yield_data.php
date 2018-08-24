<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemarksFieldToYieldData extends Migration
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
            $table->text('remarks')->nullable()->after('mrr');
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
            $table->dropColumn('remarks');
        });
    }
}
