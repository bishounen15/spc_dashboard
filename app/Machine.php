<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Machine extends Model implements Auditable
{
    //
    protected $connection = 'proddt';
    protected $fillable = [
        'code',
        'descr',
        'capacity',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'code',
        'descr',
        'capacity',
    ];
}
