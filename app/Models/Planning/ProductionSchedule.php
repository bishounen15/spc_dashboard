<?php

namespace App\Models\Planning;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use DB;

class ProductionSchedule extends Model implements Auditable
{
    //
    protected $connection = 'planning';
    protected $table = 'production_schedules';

    protected $fillable = [
        'production_date',
        'work_week',
        'weekday',
        'activity',
        'cells',
        'backsheets',
        'shifts',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'production_date',
        'work_week',
        'weekday',
        'activity',
        'cells',
        'backsheets',
        'shifts',
    ];

    public function associated($sched_id) {
        $data = DB::connection('planning')->table('production_schedule_shifts')
                        ->where([
                            ["schedule_id","=",$this->id],
                            ["shift_id","=",$sched_id],
                        ])
                        ->count();
        return $data;
    }

    public function selectedShifts() {
        return $this->hasMany('App\Models\Planning\ProductionScheduleShift', 'schedule_id', 'id');
    }

    public function products() {
        return $this->hasMany('App\Models\Planning\ProductionScheduleProduct', 'schedule_id', 'id');
    }
}
