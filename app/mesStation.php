<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class mesStation extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'lts02';
    
    public function routing() {
        return $this->hasMany('App\mesRouting', 'STNID', 'STNID');
    }
}
