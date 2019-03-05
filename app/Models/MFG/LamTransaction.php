<?php

namespace App\Models\MFG;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LamTransaction extends Model implements Auditable
{
    //
    protected $connection = 'mfg';
    
    protected $fillable = [
        'control_no',
        'station_id',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'control_no',
        'station_id',
    ];

    public function details() {
        return $this->hasMany('App\Models\MFG\LamTransactionDetail', 'trx_id', 'id');
    }

    public function station() {
        return $this->hasOne('App\Station', 'id', 'station_id');
    }
}
