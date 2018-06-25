<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OSUofM extends Model implements Auditable
{
    //
    protected $connection = 'osi';
    protected $table = 'uofms';
    protected $fillable = [
        'code',
        'description',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'code',
        'description',
    ];

    public static function GenerateCode() {
        $uofm = OSUofM::orderBy("code","desc")
                            ->first();

        if ($uofm == null) {
            $series = 1;
        } else {
            $series = intval(substr($uofm->code,4,2)) + 1;
        }

        $code = "UOM-" . sprintf("%'.02d",($series));

        return $code;
    }
}
