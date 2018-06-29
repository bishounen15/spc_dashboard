<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class frameSqBw extends Model
{
    // //   //
      //Table Name
      protected $table = 'frame_sq_bws';
      //Primary Key
      protected $connection = 'spc';
      protected $primaryKey = 'id';
      //Timestamp
      public $timestamps = true;
}
