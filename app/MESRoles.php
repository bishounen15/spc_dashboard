<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MESRoles extends ReadOnlyBase
{
    //
    protected $object_array = [
        [
            "code" => "OPRT",
            "description" => "Operator",
        ],
        [
            "code" => "QUAL",
            "description" => "QA User",
        ],
        [
            "code" => "PLAN",
            "description" => "Planner",
        ],
        [
            "code" => "SHIP",
            "description" => "Shipping",
        ],
        [
            "code" => "WHSE",
            "description" => "Warehouse",
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
