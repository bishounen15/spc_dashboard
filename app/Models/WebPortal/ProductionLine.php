<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class ProductionLine extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'lin01';
    protected $primaryKey = 'ROWID';
}
