<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfflineMatSolderingPost extends Model
{
    // Table Name
    protected $connection = 'spc';
    protected $table = 'offlinematsoldering';
    //Primary Key
    public $primarykey = 'id';
    //Timestamps
    public $timestamps = true;
}

