<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class palletData extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'epl02';

    public function pallet() {
        return $this->hasOne('App\Pallets', 'PALLETNO', 'PALLETNO');
    }
}
