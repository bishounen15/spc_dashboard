<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class MESAdditional extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'mes02';

    protected $fillable = [
        'SERIALNO',
        'LOCNCODE',
        'INFOTYPE',
        'FIELDNAME',
        'FIELDVALUE',
    ];
}
