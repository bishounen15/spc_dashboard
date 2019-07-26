<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebPortal\WorkOrder;

class WorkOrdersController extends Controller
{
    //
    public function generateControl($date = null) {
        $dt = $date ? date_format(date_create($date),"ym") : date("ym");

        $wo = WorkOrder::orderBy("WOID","DESC")
                            ->where("WOID","LIKE", $dt . "%")
                            ->first();

        if ($wo == null) {
            $series = sprintf("%05d",1);
        } else {
            $woid = $wo->WOID;
            $series = sprintf("%05d",substr($woid,5,5) + 1);
        }

        return $dt . $series;
    }
}
