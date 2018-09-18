<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BOMtype extends Model
{
     //protected $connection = 'spc';
     protected $table = 'bomtype';
     //Primary Key
     protected $primaryKey = 'id';
     //Timestamp
     public $timestamps = true;
}
