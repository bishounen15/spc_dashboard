<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConversionToItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('web_portal')->table('im01', function (Blueprint $table) {
            $table->float('conv_rcvd', 12, 5)->default(0)->after('uofm_rcvd');
            $table->float('conv_issue', 12, 5)->default(0)->after('uofm_issue');
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
        Schema::connection('web_portal')->table('im01', function (Blueprint $table) {
            $table->dropColumn('conv_rcvd');
            $table->dropColumn('conv_issue');
        });
    }
}
