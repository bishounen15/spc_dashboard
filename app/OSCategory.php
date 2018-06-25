<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class OSCategory extends Model implements Auditable
{
    //
    protected $connection = 'osi';
    protected $table = 'categories';
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
        $category = OSCategory::orderBy("code","desc")
                            ->first();

        if ($category == null) {
            $series = 1;
        } else {
            $series = intval(substr($category->code,4,2)) + 1;
        }

        $code = "CAT-" . sprintf("%'.02d",($series));

        return $code;
    }
}
