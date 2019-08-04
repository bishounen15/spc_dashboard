<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class Cabinet extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'cab01';
    protected $primaryKey = 'ROWID';
}
