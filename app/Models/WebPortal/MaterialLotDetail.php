<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class MaterialLotDetail extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'ml01';

    protected $fillable = [
        'parent_lot',
        'child_lot',
        'qty',
    ];
}
