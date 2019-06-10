<?php

namespace App\Http\Controllers\TRINA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use DataTables;
use DB;
use Response;

class ShipmentController extends Controller
{
    //
    public function __construct()
    {
        date_default_timezone_set('Asia/Manila');
    }

    public function index()
    {
        //
        return view('mes.trina.shipping.index');
    }

    public function load() {
        $ship = DB::connection("trina")->select("SELECT A.Container_no, RIGHT(B.WorkOrder_ID,3) AS WO, E.Product_Type, MAX(A.buildcabtime) AS Container_Time, COUNT(DISTINCT A.Carton_no) AS TotalCarton, CASE WHEN C.container_no IS NOT NULL THEN 'Yes' ELSE 'No' END AS IsShipped FROM omes.rt_mid_buildcontainer A INNER JOIN omes.rt_mid_packing B ON A.Carton_no = B.Carton_no INNER JOIN omes.df_wo_mat D ON B.WorkOrder_ID = D.WorkOrder_ID AND B.WorkOrder_vertion = D.WorkOrder_vertion INNER JOIN omes.df_pid_type_mapping E ON D.Product_ID = E.Q1_ID LEFT JOIN solarph.shipped_container C ON A.Container_no = C.container_no WHERE A.builduser = 'shipping' GROUP BY A.Container_no, RIGHT(B.WorkOrder_ID,3), E.Product_Type ORDER BY IsShipped, CAST(SUBSTR(A.Container_no,8,2) as SIGNED), WO");

        return Datatables::of($ship)->make(true);
    }

    public function markShipment(Request $request, $shipment_date, $cipl_no, $pl_no) {
        $contnos = [];
        
        $cnos = [];
        $cnos = explode("|",$request->containers . "|");

        foreach($cnos as $k => $v) {
            if ($v != "") {
                array_push($contnos,[ 
                    "container_no" => $v, 
                    "shipment_date" => $shipment_date, 
                    "cipl_no" => $cipl_no, 
                    "pl_no" => $pl_no,
                    "user_id" => Auth::user()->user_id
                    ]);
            }
        }

        $results = DB::connection('trina')
                            ->table('solarph.shipped_container')
                            ->insert($contnos);

        return Response::json($results);
    }
}
