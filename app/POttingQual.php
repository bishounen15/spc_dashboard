<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class POttingQual extends Model
{
    //
      //Table Name
      protected $connection = 'spc';
      protected $table = 'potting_quals';
      //Primary Key
      protected $primaryKey = 'id';
      //Timestamp
      public $timestamps = true;
      
}
