<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddProdBuilt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   
    public function up()
    {
        
        Schema::table('btobpulltest', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
        Schema::table('curing_tests', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
        Schema::table('flashes', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
        Schema::table('frame_quals', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
        Schema::table('frame_sq_bws', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
        Schema::table('jbox_dis_wt_quals', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
        Schema::table('lams', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
        Schema::table('matrix_pull_tests', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
       
        Schema::table('offlinematsoldering', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
        Schema::table('pottant_quals', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
        Schema::table('potting_quals', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
        Schema::table('pull_tests', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
    
        Schema::table('solder_temps', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });
        Schema::table('stringers', function (Blueprint $table) {
            //
            $table->string('prodBuilt');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('btobpulltest', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
        Schema::table('curing_tests', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
        Schema::table('flashes', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
        Schema::table('frame_quals', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
        Schema::table('frame_sq_bws', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
        Schema::table('jbox_dis_wt_quals', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
        Schema::table('lams', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
        Schema::table('matrix_pull_tests', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
       
        Schema::table('offlinematsoldering', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
        Schema::table('pottant_quals', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
        Schema::table('potting_quals', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
        Schema::table('pull_tests', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
    
        Schema::table('solder_temps', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });
        Schema::table('stringers', function (Blueprint $table) {
            //
            $table->dropColumn('prodBuilt');
        });

    }

}
