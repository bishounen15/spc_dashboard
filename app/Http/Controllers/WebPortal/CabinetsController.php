<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\ProductionLine;
use App\Models\Packaging\PackingLists;
use App\Models\WebPortal\IPAssign;
use App\Models\WebPortal\Cabinet;

use DB;
use Request as Req;
use Response;

class CabinetsController extends Controller
{
    public function __construct(  )
    {
        date_default_timezone_set('Asia/Manila');
    }

    //
    public function index() {
        $assignment = IPAssign::where("IPADDRESS",Req::ip())->first();
        
        $data = [];
        
        // $prodline = ProductionLine::where("LINCODE",$assignment->PRODLINE)->first();
        // $data['prodline'] = $prodline;

        return view('mes.transactions.cabinet', $data);
    }

    public function listCabinets() {
        $cabinets = DB::connection('web_portal')
                            ->table('cab01 AS A')
                            ->join('cab02 AS B','A.CABINETNO','=','B.CABINETNO')
                            ->join('epl02 AS C','B.PALLETNO','=','C.PALLETNO')
                            ->selectRaw('A.CABINETNO, A.TRXDATE, A.REGISTRATION, COUNT(DISTINCT B.PALLETNO) AS PALLETS, COUNT(C.SERIALNO) AS MODULES, A.SHIPDATE')
                            ->groupBy("A.CABINETNO", "A.TRXDATE", "A.REGISTRATION", "A.SHIPDATE")
                            ->orderByRaw('A.CABINETNO DESC')
                            ->paginate(10);
        
        return Response::json($cabinets);
    }

    public function checkPallet($pallet_no) {
        $pallet = PackingLists::where("PALLETNO",$pallet_no)->first();

        $data = [];

        if ($pallet != null) {
            $data['pallet_no'] = $pallet->PALLETNO;
            $data['cabinet_no'] = $pallet->cabinet()->first() != null ? $pallet->cabinet()->first()->CABINETNO : '';
            $data['customer'] = $pallet->CUSTOMER;
            $data['registration'] = $pallet->REGISTRATION;
            $data['modules'] = $pallet->details()->count();
        }

        return Response::json($data);
    }

    public function saveCabinet(Request $request) {
        $header = [];

        foreach($request->cabinet as $info) {
            
            $header[$info['name']] = $info['value'];
            
        }

        $registration = $header['REGISTRATION'];

        $date = date("Y-m-d",strtotime("Today"));
        $time = date('H:i');
        
        if ($time < "06:00") {
            $date = date("Y-m-d",strtotime("-1 days",strtotime($date)));
        }

        $last_cabinet = Cabinet::where(
                            [
                                ["TRXDATE",$date],
                                ["REGISTRATION",$registration],
                            ]
                        )->orderBy("CABINETNO",'DESC')
                        ->first();

        if ($last_cabinet == null) {
            $series = sprintf("%03d",1);;
        } else {
            $series = sprintf("%03d",substr($last_cabinet->CABINETNO,11,3) + 1);
        }

        $header['CABINETNO'] = "CAB".substr($header['REGISTRATION'],0,1).str_replace('-','',substr($date,2,8)).$series;
        $header['TRXDATE'] = $date;
        $header['TRXUID'] = $request->user_id;

        $cabinet = DB::connection('web_portal')
                            ->table('cab01')
                            ->insert($header);

        if ($cabinet) {
            $details = [];
            foreach($request->pallets as $pallet) {
                array_push($details, [
                    "CABINETNO" => $header['CABINETNO'],
                    "PALLETNO" => $pallet['pallet_no'],
                ]);
            }

            $pallets = DB::connection('web_portal')
                            ->table('cab02')
                            ->insert($details);

            if ($pallets) {
                $msg = "Success";
            } else {
                $msg = "Failed to save pallets.";
            }
        } else {
            $msg = "Failed to save cabinet.";
        }

        return Response::json($msg);
    }

    public function shipCabinet(Request $request) {
        $ship_details = [];

        foreach($request->ship_details as $info) {
            $ship_details[$info['name']] = $info['value'];
        }

        $updated = DB::connection('web_portal')
                        ->table('cab01')
                        ->whereIn('CABINETNO',$request->cabinets_selected)
                        ->update($ship_details);

        return Response::json($updated);
    }
}
