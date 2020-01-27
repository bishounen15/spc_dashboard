<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mesRouting extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'rou01';

    public function stationInfo() {
        return $this->belongsTo('App\mesStation', 'SRCLOC', 'STNCODE');
    }

    public function nextStation() {
        return $this->belongsTo('App\mesStation', 'STNID', 'STNID');
    }
}
