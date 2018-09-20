<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DTType extends Model implements Auditable
{
    //
    protected $connection = 'proddt';
    protected $table = 'dt_types';
    protected $fillable = [
        'machine_id',
        'category_id',
        'downtime',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'machine_id',
        'category_id',
        'downtime',
    ];
}
