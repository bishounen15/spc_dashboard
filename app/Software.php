<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    //
    protected $connection = 'assets';
    protected $table = 'tbl_software';
    //Primary Key
    protected $primaryKey = 'rowid';
    public $timestamps = false;
    
    protected $fillable = [
        'id',
        'install_date',
        'app_name',
        'version',
        'install_type',
    ];
}
