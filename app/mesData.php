<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mesData extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'mes01';

    public function date() {
        $time = date("H:i",strtotime($this->TRXDATE));
        return date('Y-m-d', strtotime( ($time < date("H:i",strtotime('06:00')) ? '-1' : '0') . ' day', strtotime($this->TRXDATE)));
    }

    public function shift() {
        $time = date("H:i",strtotime($this->TRXDATE));

        if ($time >= date("H:i",strtotime('06:00')) && $time < date("H:i",strtotime('14:00'))) {
            $shift = 'A';
        } else if ($time >= date("H:i",strtotime('14:00')) && $time < date("H:i",strtotime('14:00'))) {
            $shift = 'B';
        } else {
            $shift = 'C';
        }
        
        return $shift;
    }

    public function moduleStatus() {
        if ($this->SNOSTAT == 0) {
            $status = 'GOOD';
        } else if ($this->SNOSTAT == 1) {
            $status = 'MRB';
        } else {
            $status = 'SCRAP';
        }
        
        return $status;
    }

    public function portalUser() {
        return $this->belongsTo('App\portalUser', 'TRXUID', 'USERID');
    }

    public function user() {
        return $this->belongsTo('App\User', 'TRXUID', 'user_id'); 
    }

    public function serial() {
        return $this->hasMany('App\SerialInfo', 'SERIALNO', 'SERIALNO');
    }

    public function station() {
        return $this->belongsTo('App\mesStation', 'LOCNCODE', 'STNCODE'); 
    }
}
