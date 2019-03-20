<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Shift extends Model implements Auditable
{
    //
    protected $connection = 'planning';
    protected $table = 'shifts';

    protected $fillable = [
        'code',
        'descr',
        'start_time',
        'end_time',
        'overday',
        'duration',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'code',
        'descr',
        'start_time',
        'end_time',
        'overday',
        'duration',
    ];
}
