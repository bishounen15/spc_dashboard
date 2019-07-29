<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWoToScheduleProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::connection('planning')->table('production_schedule_products', function (Blueprint $table) {
            $table->string('work_order')->nullable()->after('schedule_id');
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
        Schema::connection('planning')->table('production_schedule_products', function (Blueprint $table) {
            $table->dropColumn('work_order');
        });
    }
}
