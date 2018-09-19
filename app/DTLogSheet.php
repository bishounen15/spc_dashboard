<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DTLogSheet extends Model implements Auditable
{
    //
    protected $connection = 'proddt';
    protected $table = 'log_sheets';
    protected $fillable = [
        'date',
        'shift',
        'station_id',
        'start',
        'end',
        'duration',
        'downtime_id',
        'remarks',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'date',
        'shift',
        'station_id',
        'start',
        'end',
        'duration',
        'downtime_id',
        'remarks',
    ];

    public function issue() {
        return $this->hasOne('App\DTType', 'id', 'downtime_id');
    }
}
