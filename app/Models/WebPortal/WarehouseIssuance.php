<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class WarehouseIssuance extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'wi01';
    protected $fillable = [
        "trx_type",
        "production_date",
        "production_line",
        "registration",
        "product_type",
        "mits_number",
        "requestor",
    ];
}
