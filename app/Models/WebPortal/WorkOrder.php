<?php

namespace App\Models\WebPortal;

use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    //
    protected $connection = 'web_portal';
    protected $table = 'wor01';
    protected $primaryKey = 'id';
}
