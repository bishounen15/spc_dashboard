<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class BOMInfo extends Model
{
    //

    protected $connection = 'web_portal';
    protected $table = 'typ01';
    protected $primaryKey = "ROWID";

    protected $fillable = [
        'PRODTYPE',
        'BOMCODE',
        'BOMDESC',
        'ACTIVE',
    ];
}
