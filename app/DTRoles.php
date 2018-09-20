<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DTRoles extends  ReadOnlyBase
{
    //
    protected $object_array = [
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