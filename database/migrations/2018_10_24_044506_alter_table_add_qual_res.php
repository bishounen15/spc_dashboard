<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableAddQualRes extends Migration
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
             $table->string('qualRes');
        });
        Schema::table('offlinematsoldering', function (Blueprint $table) {
            //
             $table->string('qualRes');
        });
        Schema::table('stringers', function (Blueprint $table) {
            //
             $table->string('qualRes');
        });
        Schema::table('rtobpulltest', function (Blueprint $table) {
            //
             $table->string('qualRes');
        });
        Schema::table('mat_solderings', function (Blueprint $table) {
            //
             $table->string('qualRes');
        });
        Schema::table('lams', function (Blueprint $table) {
            //
             $table->string('qualRes');
        });
        Schema::table('pull_tests', function (Blueprint $table) {
            //
             $table->string('qualRes');
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
             $table->dropColumn('qualRes');
        });
        Schema::table('offlinematsoldering', function (Blueprint $table) {
            //
             $table->dropColumn('qualRes');
        });
        Schema::table('stringers', function (Blueprint $table) {
            //
             $table->dropColumn('qualRes');
        });
        Schema::table('rtobpulltest', function (Blueprint $table) {
            //
             $table->dropColumn('qualRes');
        });
        Schema::table('mat_solderings', function (Blueprint $table) {
            //
             $table->dropColumn('qualRes');
        });
        Schema::table('lams', function (Blueprint $table) {
            //
             $table->dropColumn('qualRes');
        });
        Schema::table('pull_tests', function (Blueprint $table) {
            //
             $table->dropColumn('qualRes');
        });
       
    }
}
