<?php

namespace App\Models\Packaging;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PackingLists extends Model implements Auditable
{
    //
    protected $connection = 'web_portal';
    protected $table = 'epl01';
    protected $primaryKey = 'ROWID';

    const CREATED_AT = 'DTCREATE';
    const UPDATED_AT = 'DTMODIFY';

    protected $fillable = [
        'PALLETNO',
        'CARTONNO',
        'PRODUCTNO',
        'CUSTOMER',
        'MODELNAME',
        'TRXDATE',
        'PALLETSTAT',
        'UIDCREATE',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'PALLETNO',
        'CARTONNO',
        'PRODUCTNO',
        'CUSTOMER',
        'MODELNAME',
        'TRXDATE',
        'PALLETSTAT',
        'UIDCREATE',
    ];

    public function details() {
        return $this->hasMany('App\Models\Packaging\PackingListItems', 'PALLETNO', 'PALLETNO');
    }
}
