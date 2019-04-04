<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ftdData extends Model implements Auditable
{
    //
    protected $connection = 'web_portal';
    protected $table = 'ftd_raw';
    protected $primaryKey = 'ROWID';
    public $timestamps = false;

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'ModuleID',
    ];

    protected $auditEvents = [
        'updated',
    ];
}
