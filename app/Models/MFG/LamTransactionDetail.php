<?php

namespace App\Models\MFG;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LamTransactionDetail extends Model implements Auditable
{
    //
    protected $connection = 'mfg';
    
    protected $fillable = [
        'trx_id',
        'serial_no',
        'location',
        'date_scanned',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'trx_id',
        'serial_no',
        'location',
        'date_scanned',
    ];
}
