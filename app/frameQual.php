<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class frameQual extends Model
{
    //   //
      //Table Name
      // protected $connection = 'spc';
      protected $table = 'frame_quals';
      //Primary Key
      protected $primaryKey = 'id';
      //Timestamp
      public $timestamps = true;
}
