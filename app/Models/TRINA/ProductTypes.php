<?php

namespace App\Models\TRINA;

use Illuminate\Database\Eloquent\Model;

class ProductTypes extends Model
{
    //
    protected $connection = "trina";
    protected $table = "df_pid_type_mapping";
}
