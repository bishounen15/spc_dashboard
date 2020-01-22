<?php

namespace App\Models\Trina;

use Illuminate\Database\Eloquent\Model;

class ModuleID extends Model
{
    //
    protected $connection = "trina";
    protected $table = "rt_wo_mid";

    protected $primaryKey = "Module_ID";
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'Module_ID',
        'EL_Grade',
    ];

    public function portalInfo() {
        return $this->hasMany('App\SerialInfo', 'SERIALNO', 'Module_ID');
    }

    public function workOrderDetails() {
        return WorkOrder::where([
            ["WorkOrder_ID",$this->WorkOrder_ID],
            ["WorkOrder_vertion",$this->WorkOrder_vertion]
        ])->first();
    }
}
