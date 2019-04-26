<?php

namespace App\Models\TRINA;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OBAHistory extends Model implements Auditable
{
    //
    protected $connection = 'trina';
    protected $table = 'solarph.oba_history';

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
