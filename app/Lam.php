<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lam extends Model
{
    // protected $connection = 'spc';
    protected $table = 'Lams';
    public $primaryKey = 'id';

    protected $fillable = [
        'Date',
        'Laminator',
        'Shift',
        'Recipe',
        'Glass',
        'ModuleID',
        'EVA',
        'Backsheet',
        'Location',
        'LXM1',
        'LXM2',
        'LXM3',
        'LXM4',
        'LXM5',
        'LXM6',
        'LXM7',
        'LXM8',
        'LXM9',
        'LXM10',
        'LXM11',
        'LXM12',
        'LXM13',
        'LXM14',
        'LXM15',
        'LXM16',
        'LXMA',
        'RelGel1',
        'RelGel2',
        'RelGel3',
        'RelGel4',
        'RelGel5',
        'RelGel6',
        'RelGel7',
        'RelGel8',
        'RelGel9',
        'RelGel10',
        'RelGel11',
        'RelGel12',
        'RelGel13',
        'RelGel14',
        'RelGel15',
        'RelGel16',
        'RelGelA',
    ];
}
