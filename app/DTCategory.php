<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DTCategory extends Model implements Auditable
{
    //
    protected $connection = 'proddt';
    protected $table = 'categories';

    protected $fillable = [
        'code',
        'descr',
        'color_scheme',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'code',
        'descr',
        'color_scheme',
    ];
}
