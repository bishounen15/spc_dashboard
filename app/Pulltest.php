<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pulltest extends Model
{
    protected $connection = 'spc';
    protected $table = 'Pulltests';
    public $primaryKey = 'id';
}
