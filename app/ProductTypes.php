<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductTypes extends Model implements Auditable
{
    //
    protected $connection = 'yield';
    protected $fillable = [
        'code',
        'descr',
        'target',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'code',
        'descr',
        'target',
    ];
}
