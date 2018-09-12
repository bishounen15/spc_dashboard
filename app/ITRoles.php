<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ITRoles extends  ReadOnlyBase
{
    //
    protected $object_array = [
        [
            "code" => "VIEW",
            "description" => "Viewing",
        ],
        [
            "code" => "MNGE",
            "description" => "Manage",
        ],
        [
            "code" => "ADMIN",
            "description" => "Administrator",
        ],
    ];
}