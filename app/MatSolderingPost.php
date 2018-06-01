<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatSolderingPost extends Model
{
    // Table Name
    protected $connection = 'spc';
    protected $table = 'mat_soldering';
    //Primary Key
    public $primarykey = 'id';
    //Timestamps
    public $timestamps = true;
}

