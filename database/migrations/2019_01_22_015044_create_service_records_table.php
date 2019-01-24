<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('assets')->create('service_records', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('asset_id');
            $table->date('date_raised');
            $table->string('raised_by');
            $table->string('issue_details');
            $table->date('date_reported')->nullable();
            $table->integer('reported_by')->nullable();
            $table->string('vendor_commitment')->nullable();
            $table->date('commitment_date')->nullable();
            $table->date('date_closed')->nullable();
            $table->integer('closed_by')->nullable();
            $table->string('remarks')->nullable();

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
        Schema::connection('assets')->dropIfExists('service_records');
    }
}
