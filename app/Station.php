<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Station extends Model implements Auditable
{
    //
    protected $connection = 'proddt';
    protected $fillable = [
        'code',
        'descr',
        'machine_id',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'code',
        'descr',
        'machine_id',
    ];

    public function machine() {
        return $this->hasOne('App\Machine', 'id', 'machine_id');
    }
}
