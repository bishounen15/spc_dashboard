<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ServiceLogs extends Model implements Auditable
{
    //
    protected $connection = 'assets';

    protected $fillable = [
        'service_id',
        'log_date',
        'log_details',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'service_id',
        'log_date',
        'log_details',
    ];

    public function serviceRecord() {
        return $this->belongsTo('App\ServiceRecord','service_id','id');
    }
}
