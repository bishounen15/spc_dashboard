<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoles extends ReadOnlyBase
{
    //
    protected $object_array = [
        // [
        //     "code" => "VIEW",
        //     "description" => "Viewer",
        // ],
        [
            "code" => "USER",
            "description" => "User",
        ],
        [
            "code" => "SUPV",
            "description" => "Supervisor",
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
