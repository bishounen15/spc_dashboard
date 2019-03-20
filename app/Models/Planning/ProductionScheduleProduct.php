<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductionScheduleProduct extends Model implements Auditable
{
    //
    protected $connection = 'planning';
    protected $table = 'production_schedule_products';

    protected $fillable = [
        'schedule_id',
        'model_name',
        'production_line',
        'qty',
        'cell',
        'backsheet',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'schedule_id',
        'model_name',
        'production_line',
        'qty',
        'cell',
        'backsheet',
    ];
}
