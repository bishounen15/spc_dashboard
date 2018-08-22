<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class YieldEmail extends Model implements Auditable
{
    //
    protected $connection = 'yield';
    protected $table = 'emails';

    protected $fillable = [
        'email',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'email',
    ];
}
