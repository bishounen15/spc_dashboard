<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productSelect extends Model
{
     //protected $connection = 'spc';
     protected $table = 'prodselect';
     //Primary Key
     protected $primaryKey = 'id';
     //Timestamp
     public $timestamps = true;
}
