<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToAssets extends Migration
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
            $table->string('site')->nullable()->after('host_name');
            $table->string('sub_site')->nullable()->after('site');
            $table->string('device_status')->nullable()->after('status');
            $table->text('remarks')->nullable()->after('hdd');
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
            $table->dropColumn(['site','sub_site','device_status','remarks']);
        });
    }
}
