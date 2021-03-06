<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class IPAssign extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'mac01';
    protected $primaryKey = 'ROWID';

    public function prodLine() {
        return $this->hasOne('App\Models\WebPortal\ProductionLine', 'LINCODE', 'PRODLINE')->first();
    }
}
