<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MESRoles extends ReadOnlyBase
{
    //
    protected $object_array = [
        // [
        //     "code" => "VIEW",
        //     "description" => "Viewer",
        // ],
        [
            "code" => "OPRT",
            "description" => "Operator",
        ],
        [
            "code" => "QUAL",
            "description" => "QA User",
        ],
        [
            "code" => "VIEW",
            "description" => "Viewer",
        ],
        [
            "code" => "ADMIN",
            "description" => "Administrator",
        ],
    ];
}
