<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Department extends Model implements Auditable
{
    //
    protected $fillable = [
        'description',
        'abbrv',
        'cost_center',
        'head',
        'head_email',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'description',
        'abbrv',
        'cost_center',
        'head',
        'head_email',
    ];
}
