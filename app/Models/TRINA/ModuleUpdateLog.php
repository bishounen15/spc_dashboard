<?php

namespace App\Models\TRINA;

use Illuminate\Database\Eloquent\Model;

class ModuleUpdateLog extends Model
{
    //
    protected $connection = 'trina';
    protected $table = 'solarph.module_update_logs';

    protected $fillable = [
        'Module_ID',
        'field_name',
        'old_value',
        'new_value',
        'user_id',
    ];
}
