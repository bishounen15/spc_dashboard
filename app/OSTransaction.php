<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OSTransaction extends Model implements Auditable
{
    //
    protected $connection = 'osi';
    protected $table = 'transactions';

    protected $fillable = [
        'control_no',
        'date',
        'type',
        'status',
        'remarks',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'control_no',
        'date',
        'type',
        'status',
        'remarks',
    ];

    public static function GenerateCode($type) {
        $pfx = substr($type,0,1);

        $trx = OSTransaction::orderBy("control_no","desc")
                            ->whereRaw("control_no LIKE '".$pfx.date("ym")."%'")
                            ->first();

        if ($trx == null) {
            $series = 1;
        } else {
            $series = intval(substr($trx->control_no,6,4)) + 1;
        }

        $code = $pfx . date("ym") . "-" . sprintf("%'.04d",($series));

        return $code;
    }

    public function details() {
        return $this->hasMany('App\OSTransactionDetail', 'transaction_id', 'id');
    }
}
