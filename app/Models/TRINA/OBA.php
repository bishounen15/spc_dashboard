<?php

namespace App\Models\TRINA;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OBA extends Model implements Auditable
{
    //
    protected $connection = 'trina';
    protected $table = 'solarph.oba';

    protected $fillable = [
        'Module_ID',
        'Carton_no',
        'Judgement',
        'Remarks',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'Module_ID',
        'Carton_no',
        'Judgement',
        'Remarks',
    ];
}
