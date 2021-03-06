<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class BOM extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'bm01';

    protected $fillable = [
        'product_type',
        'category',
        'item_class',
        'bom_qty',
        'bom_index',
    ];
}
