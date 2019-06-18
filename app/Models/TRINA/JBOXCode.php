<?php

namespace App\Models\TRINA;

use Illuminate\Database\Eloquent\Model;

class JBOXCode extends Model
{
    //
    protected $connection = "trina";
    protected $table = "df_jbox_code";

    protected $primaryKey = "jbox_Code";
    public $incrementing = false;
    public $timestamps = false;
}
