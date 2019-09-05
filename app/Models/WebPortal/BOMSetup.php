<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class BOMSetup extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'bs01';

    protected $fillable = [
        'category',
        'item_class',
        'item_index'
    ];
}
