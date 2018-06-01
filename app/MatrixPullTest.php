<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MatrixPullTest extends Model
{
    // Table Name
    protected $connection = 'spc';
    protected $table = 'matrix_pull_tests';
    //Primary Key
    public $primarykey = 'id';
    //Timestamps
    public $timestamps = true;
}

