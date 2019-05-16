<?php

namespace App\Models\TRINA;

use Illuminate\Database\Eloquent\Model;

class MidFlash extends Model
{
    //
    protected $connection = "trina";
    protected $table = "rt_mid_flash";

    protected $primaryKey = "Module_ID";
    public $incrementing = false;
    public $timestamps = false;
}
