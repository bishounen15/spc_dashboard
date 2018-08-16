<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddlFieldsForUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('users', function (Blueprint $table) {
            $table->string('dept_id')->nullable()->after('name');
            $table->boolean('osi_access')->nullable()->after('password');
            $table->string('osi_role')->nullable()->after('osi_access');
            $table->boolean('yield_access')->nullable()->after('osi_role');
            $table->string('yield_role')->nullable()->after('yield_access');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['dept_id','osi_access','osi_role','yield_access','yield_role']);
        });
    }
}
