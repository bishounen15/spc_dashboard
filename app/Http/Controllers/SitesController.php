<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sites;

use Response;

class SitesController extends Controller
{
    //
    public function sites($site = null) {
        $cond = [];

        if ($site) {
            $mysite = Sites::where("descr",$site)->first()->id;
            array_push($cond,["parent_site",$mysite]);
        } else {
            array_push($cond,["parent_site",0]);
        }

        $sites = Sites::where($cond)->select("id","descr")->orderBy("descr","ASC")->get();

        return Response::json($sites);
    }
}
