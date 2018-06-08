<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lam extends Model
{
    protected $connection = 'spc';
    protected $table = 'Lams';
    public $primaryKey = 'id';
}
