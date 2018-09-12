<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    //
    protected $connection = 'assets';
    protected $table = 'tbl_general';
    //Primary Key
    protected $primaryKey = 'id';
}
