<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HDDPartitions extends Model
{
    //
    protected $connection = 'assets';
    protected $table = 'tbl_hdd';
    //Primary Key
    protected $primaryKey = 'rowid';
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'root_dir',
        'capacity',
        'free_space',
    ];
}
