<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductionTeam extends ReadOnlyBase
{
    //
    protected $object_array = [
        [
            "code" => "MARIE",
            "description" => "Team MARIE",
        ],
        [
            "code" => "EDCOR",
            "description" => "Team EDCOR",
        ],
        [
            "code" => "MANNY",
            "description" => "Team MANNY",
        ],
    ];
}
