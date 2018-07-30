<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatSolderingPost extends Model
{
    // Table Name
    protected $table = 'mat_solderings';
    //Primary Key
    public $primarykey = 'id';
    //Timestamps
    public $timestamps = true;
}

