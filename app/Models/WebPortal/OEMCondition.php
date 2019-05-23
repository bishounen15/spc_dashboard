<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class OEMCondition extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'cnd00';
    protected $primaryKey = 'ROWID';
}
