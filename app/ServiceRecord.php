<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ServiceRecord extends Model implements Auditable
{
    //
    protected $connection = 'assets';

    protected $fillable = [
        'asset_id',
        'date_raised',
        'raised_by',
        'issue_details',
        'date_reported',
        'reported_by',
        'vendor_commitment',
        'commitment_date',
        'date_closed',
        'closed_by',
        'remarks',
    ];

    use \OwenIt\Auditing\Auditable;
    protected $auditInclude = [
        'asset_id',
        'date_raised',
        'raised_by',
        'issue_details',
        'date_reported',
        'reported_by',
        'vendor_commitment',
        'commitment_date',
        'date_closed',
        'closed_by',
        'remarks',
    ];

    public function asset() {
        return $this->belongsTo('App\Assets','asset_id','id');
    }

    public function logs() {
        return $this->hasMany('App\ServiceLogs','id','service_id');
    }
}
