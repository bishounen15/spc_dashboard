<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGfxCardToAsset extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('assets')->table('tbl_general', function (Blueprint $table) {
            $table->string('gfx_card')->nullable()->after('hdd');
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
        Schema::connection('assets')->table('tbl_general', function (Blueprint $table) {
            $table->dropColumn('gfx_card');
        });
    }
}
