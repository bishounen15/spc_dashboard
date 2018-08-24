<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrixPullTest extends Model
{
    // Table Name
    protected $table = 'rtobpull';
    //Primary Key
    public $primarykey = 'id';
    //Timestamps
    public $timestamps = true;
}

