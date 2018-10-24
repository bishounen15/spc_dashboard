<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sites extends Model
{
    //
    protected $connection = 'assets';
    protected $table = 'sites';
    //Primary Key
    protected $primaryKey = 'id';
}
