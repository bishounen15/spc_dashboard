<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrixPullTest extends Model
{
    // Table Name
    protected $connection = 'spc';
    protected $table = 'rtobpull';
    //Primary Key
    public $primarykey = 'id';
    //Timestamps
    public $timestamps = true;
}

