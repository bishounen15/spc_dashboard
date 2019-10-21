<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class LotTransactionDetail extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'lt02';

    protected $fillable = [
        'SERIALNO',
        'INDEXNO',
        'LOTNUMBER',
    ];
}
