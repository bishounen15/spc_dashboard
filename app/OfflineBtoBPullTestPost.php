<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OfflineBtoBPullTestPost extends Model
{
    // Table Name
    protected $table = 'btobpulltest';
    //Primary Key
    public $primarykey = 'id';
    //Timestamps
    public $timestamps = true;
}

