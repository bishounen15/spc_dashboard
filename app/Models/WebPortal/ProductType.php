<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'typ00';
    protected $primaryKey = 'ROWID';
}
