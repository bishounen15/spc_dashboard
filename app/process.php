<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class process extends Model
{
    //protected $connection = 'spc';
    protected $table = 'process';
    //Primary Key
    protected $primaryKey = 'id';
    //Timestamp
    public $timestamps = true;
}
