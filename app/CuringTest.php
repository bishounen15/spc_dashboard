<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CuringTest extends Model
{
       //
      //Table Name
      // protected $connection = 'spc';
      protected $table = 'curing_tests';
      //Primary Key
      protected $primaryKey = 'id';
      //Timestamp
      public $timestamps = true;
}
