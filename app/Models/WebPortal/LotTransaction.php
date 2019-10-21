<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class LotTransaction extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'lt01';

    protected $fillable = [
        'LOCNCODE',
        'PRODLINE',
        'MACHINE',
        'SERIALNO',
        'UIDTRANS',
    ];
}
