<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class BOMComponent extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'bm02';
    
    protected $fillable = [
        'bom_id',
        'item_code',
    ];
}
