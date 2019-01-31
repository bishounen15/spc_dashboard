<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductionSchedule extends Model implements Auditable
{
    //
    protected $connection = 'web_portal';
    protected $table = 'sch01';

    protected $fillable = [
        'production_date',
        'work_week',
        'weekday',
        'shifts',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'production_date',
        'work_week',
        'weekday',
        'shifts',
    ];
}
