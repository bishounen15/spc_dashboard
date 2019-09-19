<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\ProductionLine;
use DB;
use Response;

class ProductionLinesController extends Controller
{
    //
    public function selectValues() {
        $prodlines = ProductionLine::select("LINCODE AS value","LINDESC AS caption")
                                    ->orderBy("LINDESC","ASC")
                                    ->get();

        return Response::json(["data" => $prodlines]);
    }

    public function withSchedule($production_date = null) {
        $prod_date = $production_date == null ? date('Y-m-d') : $production_date;
        $prodlines = DB::connection('web_portal')
                            ->select("SELECT DISTINCT C.LINCODE AS value, CONCAT(C.LINDESC,' - ',C.LINCAT) AS caption FROM sp_planning.production_schedules A INNER JOIN sp_planning.production_schedule_products B ON A.id = B.schedule_id INNER JOIN spmmc00.lin01 C ON B.production_line = C.LINCODE WHERE A.production_date = ? ORDER BY caption",[$prod_date]);

        return Response::json(["data" => $prodlines]);
    }

    public function loadSchedule($date, $line) {
        $details = DB::connection('web_portal')
                            ->select('SELECT B.model_name AS product_type, C.LINCAT AS registration FROM sp_planning.production_schedules A INNER JOIN sp_planning.production_schedule_products B ON A.id = B.schedule_id INNER JOIN spmmc00.lin01 C ON B.production_line = C.LINCODE WHERE A.production_date = ? AND B.production_line = ? ORDER BY product_type',[$date,$line]);

        return Response::json(['data' => $details]);
    }
}
