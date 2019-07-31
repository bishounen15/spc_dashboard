<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WebPortal\ProductType;
use App\Models\WebPortal\ProductionLine;
use App\Models\Planning\ProductionSchedule;
use App\Models\Planning\ProductionScheduleProduct;

use Response;

class ProductTypesController extends Controller
{
    //
    public function selectValues() {
        $prodtypes = ProductType::select("PRODTYPE AS value","PRODTYPE AS caption")
                                    ->where("CUSTOMER","<>","TRINA")
                                    ->orderBy("PRODTYPE","ASC")
                                    ->get();

        return Response::json(["data" => $prodtypes]);
    }

    public function listProducts($date, $line) {
        $prodline = ProductionLine::where("LINDESC",$line)->first();
        $sched_id = ProductionSchedule::where("production_date",$date)->first()->id;
        $products = ProductionScheduleProduct::select("work_order","model_name")->where([
            ["schedule_id",$sched_id],
            ["production_line",$prodline->LINCODE],
        ])->get();
    
        $prods = [];
        $prod = [];
        foreach($products as $product) {
            // $prod .= ($prod == "" ? "" : "|") . $product->model_name;
            $prod["wo"] = $product->work_order;
            $prod["prodtype"] = $product->model_name;
            $prod["category"] = $prodline->LINCAT;
    
            array_push($prods,$prod);
        }
    
        return Response::json($prods);
    }
}
