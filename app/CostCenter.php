<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CostCenter extends Model implements Auditable 
{
    //
    protected $fillable = [
        'code',
        'description',
        'owner',
        'designation',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'code',
        'description',
        'owner',
        'designation',
    ];
}
