<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SolderTemp extends Model
{
    // //
      //Table Name
      protected $connection = 'spc';
      protected $table = 'solder_temps';
      //Primary Key
      protected $primaryKey = 'id';
      //Timestamp
      public $timestamps = true;
      
}
