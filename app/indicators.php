<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class indicators extends Model
{
   // protected $connection = 'spc';
    protected $table = 'indicators';
    //Primary Key
    protected $primaryKey = 'id';
    //Timestamp
    public $timestamps = true;
}
