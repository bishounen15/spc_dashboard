<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class CabinetPallet extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'cab02';
    protected $primaryKey = 'ROWID';
}
