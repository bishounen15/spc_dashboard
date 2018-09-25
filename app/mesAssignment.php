<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mesAssignment extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'lst01';

    public function stationInfo() {
        return $this->belongsTo('App\mesStation', 'STNCODE', 'STNCODE');
    }
}
