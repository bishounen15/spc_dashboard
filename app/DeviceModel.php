<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    //
    protected $connection = 'assets';
    protected $table = 'tbl_model';
    //Primary Key
    protected $primaryKey = 'id';
}
