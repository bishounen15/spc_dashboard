<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class DeviceAssignment extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'mac01';
    protected $primaryKey = 'ROWID';
}
