<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTimestampsToAssetTables extends Migration
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
            $table->timestamps();
        });

        Schema::connection('assets')->table('tbl_network', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::connection('assets')->table('tbl_software', function (Blueprint $table) {
            $table->timestamps();
        });

        Schema::connection('assets')->table('tbl_model', function (Blueprint $table) {
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
        //
        Schema::connection('assets')->table('tbl_general', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });

        Schema::connection('assets')->table('tbl_network', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });

        Schema::connection('assets')->table('tbl_software', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });

        Schema::connection('assets')->table('tbl_model', function (Blueprint $table) {
            $table->dropColumn('created_at');
            $table->dropColumn('updated_at');
        });
    }
}
