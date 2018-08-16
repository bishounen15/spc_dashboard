<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OSIRoles extends  ReadOnlyBase
{
    //
    protected $object_array = [
        [
            "code" => "RQST",
            "description" => "Requestor",
        ],
        [
            "code" => "CUST",
            "description" => "Custodian",
        ],
        [
            "code" => "ADMIN",
            "description" => "Administrator",
        ],
        // [
        //     "code" => "MNGR",
        //     "description" => "Manager",
        // ],
    ];
}