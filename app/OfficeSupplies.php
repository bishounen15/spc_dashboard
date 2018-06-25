<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OfficeSupplies extends Model implements Auditable
{
    //
    protected $connection = 'osi';
    protected $fillable = [
        'code',
        'description',
        'category_id',
        'uofm_id',
        'unit_cost',
        'stock_limit',
        'current_stock',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'code',
        'description',
        'category_id',
        'uofm_id',
        'unit_cost',
        'stock_limit',
        'current_stock',
    ];

    public static function GenerateCode() {
        $item = OfficeSupplies::orderBy("code","desc")
                            ->first();

        if ($item == null) {
            $series = 1;
        } else {
            $series = intval(substr($item->code,4,4)) + 1;
        }

        $code = "OS-" . sprintf("%'.04d",($series));

        return $code;
    }
}
