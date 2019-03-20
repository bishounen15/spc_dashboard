<?php

namespace App\Models\Packaging;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PackingListItems extends Model implements Auditable
{
    //
    protected $connection = 'web_portal';
    protected $table = 'epl02';
    protected $primaryKey = 'ROWID';

    protected $fillable = [
        'PALLETNO',
        'CARTONNO',
        'ITMIX',
        'SERIALNO',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'PALLETNO',
        'CARTONNO',
        'ITMIX',
        'SERIALNO',
    ];

    public function serialInfo() {
        return $this->hasMany('App\SerialInfo', 'SERIALNO', 'SERIALNO');
    }
}
