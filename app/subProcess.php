<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subProcess extends Model
{
    protected $connection = 'spc';
    protected $table = 'subprocess';
    //Primary Key
    protected $primaryKey = 'id';
    //Timestamp
    public $timestamps = true;
}
