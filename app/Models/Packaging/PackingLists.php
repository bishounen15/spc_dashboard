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
        'PALLETSNO',
        'CARTONNO',
        'PRODUCTNO',
        'CUSTOMER',
        'MODELNAME',
        'TRXDATE',
        'PALLETSTAT',
        'UIDCREATE',
        'REGISTRATION',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'PALLETNO',
        'PALLETSNO',
        'CARTONNO',
        'PRODUCTNO',
        'CUSTOMER',
        'MODELNAME',
        'TRXDATE',
        'PALLETSTAT',
        'UIDCREATE',
        'REGISTRATION',
    ];

    public function details() {
        return $this->hasMany('App\Models\Packaging\PackingListItems', 'PALLETNO', 'PALLETNO');
    }

    public function customer() {
        return $this->hasOne('App\portalCustomer', 'CUSCODE', 'CUSTOMER');
    }

    public function cabinet() {
        return $this->hasOne('App\Models\WebPortal\CabinetPallet', 'PALLETNO', 'PALLETNO');
    }
}
