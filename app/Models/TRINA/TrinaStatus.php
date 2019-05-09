<?php

namespace App\Models\TRINA;

use Illuminate\Database\Eloquent\Model;

class TrinaStatus extends \App\ReadOnlyBase
{
    //
    protected $object_array = [
        // [
        //     "code" => "VIEW",
        //     "description" => "Viewer",
        // ],
        [
            "code" => "Q1",
            "description" => "Q1",
        ],
        [
            "code" => "Q2",
            "description" => "Q2",
        ],
    ];
}
