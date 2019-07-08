<?php

namespace App\Models\TRINA;

use Illuminate\Database\Eloquent\Model;

class CurrentOperation extends Model
{
    //
    protected $connection = "trina";
    protected $table = "rt_tblwiplotstate";

    protected $primaryKey = "Module_ID";
    public $incrementing = false;
    public $timestamps = false;
}
