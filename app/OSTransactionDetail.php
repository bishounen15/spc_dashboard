<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OSTransactionDetail extends Model implements Auditable
{
    //
    protected $connection = 'osi';
    protected $table = 'transaction_details';

    protected $fillable = [
        'transaction_id',
        'item_id',
        'qty',
        'unit_cost',
        'total_cost',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'transaction_id',
        'item_id',
        'qty',
        'unit_cost',
        'total_cost',
    ];
}
