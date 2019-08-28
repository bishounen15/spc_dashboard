<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class ItemClass extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'lts01';
    protected $primaryKey = 'ROWID';
}
