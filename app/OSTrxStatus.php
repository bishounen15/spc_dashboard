<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OSTrxStatus extends ReadOnlyBase
{
    //
    protected $object_array = [
        [
            "status" => "Open",
            "next" => "Submitted",
        ],
        [
            "status" => "Submitted",
            "next" => "For Release",
        ],
        [
            "status" => "For Release",
            "next" => "Issued",
        ],
    ];
}
