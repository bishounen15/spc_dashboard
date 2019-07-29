<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebPortal\WorkOrder;

use Response;

class WorkOrdersController extends Controller
{
    //
    public function generateControl($date = null, $category = null) {
        $dt = $date ? date_format(date_create($date),"ym") : date("ym");

        $wo = WorkOrder::orderBy("id","DESC")
                            ->where("WOID","LIKE", $dt . "%")
                            ->first();

        if ($wo == null) {
            $series = sprintf("%03d",1);
        } else {
            $woid = $wo->WOID;
            $series = sprintf("%03d",substr($woid,6,3) + 1);
        }

        return Response::json($dt . ($category == null ? "-" : substr($category,0,1)) . $series);
    }
}
