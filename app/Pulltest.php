<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pulltest extends Model
{
    protected $connection = 'spc';
    protected $table = 'pull_tests';
    public $primaryKey = 'id';
}
