<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flash extends Model
{
    protected $connection = 'spc';
    protected $table = 'flashes';
    public $primaryKey = 'id';
}
