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
}
