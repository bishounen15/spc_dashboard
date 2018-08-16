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
            "code" => "MNGR",
            "description" => "Manager",
        ],
        [
            "code" => "ADMIN",
            "description" => "Administrator",
        ],
    ];
}
