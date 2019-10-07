<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class WarehouseIssuanceDetails extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'wi02';
    protected $fillable = [
        "issuance_id",
        "item_code",
        "uofm_base",
        "uofm_issue",
        "conv_issue",
        "base_qty",
        "issue_qty",
    ];
}
