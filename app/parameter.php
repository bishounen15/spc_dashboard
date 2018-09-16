<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class parameter extends Model
{
    //protected $connection = 'spc';
    protected $table = 'parameters';
    //Primary Key
    protected $primaryKey = 'id';
    //Timestamp
    public $timestamps = true;
}
