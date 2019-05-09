<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NetInterface extends Model
{
    //
    protected $connection = 'assets';
    protected $table = 'tbl_network';
    //Primary Key
    protected $primaryKey = 'rowid';
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'ip',
        'mac',
        'name',
        'descr',
        'interface',
    ];
}
