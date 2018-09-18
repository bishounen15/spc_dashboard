<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productType extends Model
{
     //protected $connection = 'spc';
     protected $table = 'producttype';
     //Primary Key
     protected $primaryKey = 'id';
     //Timestamp
     public $timestamps = true;
}
