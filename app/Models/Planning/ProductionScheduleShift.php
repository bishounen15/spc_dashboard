<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ProductionScheduleShift extends Model implements Auditable
{
    //
    protected $connection = 'planning';
    protected $table = 'production_schedule_shifts';

    protected $fillable = [
        'schedule_id',
        'shift_id',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'schedule_id',
        'shift_id',
    ];

    public function details() {
        return $this->hasOne('App\Models\Planning\Shift', 'id', 'shift_id');
    }
}
