<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pulltest extends Model
{
    // Table Name
    protected $table = 'pull_tests';
    //Primary Key
    public $primaryKey = 'id';
    //Primary Key
    public $timestamps = true;
}
