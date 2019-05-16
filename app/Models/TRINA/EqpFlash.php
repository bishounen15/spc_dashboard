<?php

namespace App\Models\TRINA;

use Illuminate\Database\Eloquent\Model;

class EqpFlash extends Model
{
    //
    protected $connection = "trina";
    protected $table = "rt_eqp_flash";

    protected $primaryKey = "Module_ID";
    public $incrementing = false;
    public $timestamps = false;

    public function latest() {
        $mid = \App\Models\TRINA\MidFlash::where([
            ["WorkOrder_ID", $this->WorkOrder_ID],
            ["Module_ID", $this->Module_ID],
            ["TEST_DATETIME", $this->TEST_DATETIME],
        ])->first();

        return ($mid != null);
    }
}
