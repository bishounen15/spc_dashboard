<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\LotTransaction;
use App\Models\WebPortal\LotTransactionDetail;

use App\Models\WebPortal\ProductionLine;
use App\Models\WebPortal\IPAssign;

use Request as req;
use DB;
use Response;
use Validator;

class LotTransactionsController extends Controller
{
    public function __construct() {
        date_default_timezone_set('Asia/Manila');
        $this->error_codes = [
            1062 => "You are trying to enter a duplicate record. Please check your input."
        ];
    }
    //
    public function index() {
        $assignment = IPAssign::where("IPADDRESS",Req::ip())->first();

        $data = [];

        $prodline = ProductionLine::where("LINCODE",$assignment->PRODLINE)->first();
        $data['prodline'] = $prodline;
        $data['station'] = $assignment->STATION;
        $data['machine'] = $assignment->MACHINE;

        return view('mes.transactions.stringer', $data);
    }

    public function checkLot($lot) {
        $results = DB::connection('web_portal')
                        ->select("SELECT A.child_lot as lot_id, A.parent_lot, B.PARTNUMBER AS part_number, B.DESCRIPTION AS description, B.SPEC01 * 100 AS efficiency, B.SPEC02 AS color, A.qty, COUNT(C.LOTNUMBER) AS used FROM ml01 A INNER JOIN mat01 B ON A.parent_lot = B.LOTNUMBER LEFT JOIN lt02 C ON A.child_lot = C.LOTNUMBER WHERE child_lot = ? GROUP BY A.child_lot, A.parent_lot, B.PARTNUMBER, B.DESCRIPTION, B.SPEC01 * 100, B.SPEC02, A.qty",[$lot]);

        return Response::json(['results' => $results]);
    }

    public function store(Request $request)
    {
        //
        $req = json_decode(json_decode($request->params));
        
        $data = [
            "LOCNCODE" => $req->LOCNCODE,
            "PRODLINE" => $req->PRODLINE,
            "MACHINE" => $req->MACHINE,
            "SERIALNO" => $req->SERIALNO,
            "UIDTRANS" => $req->UIDTRANS,
        ];

        $validator = Validator::make($data, [
            'SERIALNO' => 'required|unique:web_portal.lt01',
        ], [
            'SERIALNO.unique' => 'Serial Number ['.$data['SERIALNO'].'] is already transacted.',
        ]);

        $err_msg = '';

        if ($validator->fails()) {
            $err_msg = $validator->messages()->first();
        } else {
            try {
                $header = LotTransaction::create($data);
                $index = 1;
                foreach($req->lot_ids as $lot_id) {
                    $details = LotTransactionDetail::create(
                        [
                            "SERIALNO" => $header->SERIALNO,
                            "INDEXNO" => $index,
                            "LOTNUMBER" => $lot_id->lot_id,
                        ]
                    );
                    $index++;
                }
            } catch (\Throwable $th) {
                $results = $th;

                try {
                    $err_msg = $this->error_codes[$results->errorInfo[1]];
                } catch (\Throwable $th) {
                    $err_msg = $results->errorInfo[2];
                }
            } 
        }

        return Response::json($err_msg); 
    }

    public function list($station,$machine) {
        $dt = date('Y-m-d',strtotime("-" . (date('H:i') < "06:00" ? 1 : 0) . " days",strtotime("Today")));

        $start = $dt  . " 06:00:00";
        $end = date('Y-m-d',strtotime("+1 days",strtotime($dt))) . " 05:59:59";

        $sql = "SELECT A.LOCNCODE, D.LINDESC AS PRODLINE, A.MACHINE, A.SERIALNO, A.TRXDATE, IFNULL(B.LOTNUMBER,'') AS LOT1, IFNULL(C.LOTNUMBER,'') AS LOT2 FROM lt01 A INNER JOIN lin01 D ON A.PRODLINE = D.LINCODE LEFT JOIN lt02 B ON A.SERIALNO = B.SERIALNO AND B.INDEXNO = 1 LEFT JOIN lt02 C ON A.SERIALNO = C.SERIALNO AND C.INDEXNO = 2 WHERE A.TRXDATE BETWEEN ? AND  ? ORDER BY A.TRXDATE DESC";

        $results = DB::connection('web_portal')
                        ->table('lt01 AS A')
                        ->join('lin01 AS D','A.PRODLINE','D.LINCODE')
                        ->leftJoin('lt02 AS B', function ($join) {
                            $join->on('A.SERIALNO', '=', 'B.SERIALNO')
                                 ->where('B.INDEXNO', '=', 1);
                        })
                        ->leftJoin('lt02 AS C', function ($join) {
                            $join->on('A.SERIALNO', '=', 'C.SERIALNO')
                                 ->where('C.INDEXNO', '=', 2);
                        })
                        ->selectRaw("A.LOCNCODE, D.LINDESC AS PRODLINE, A.MACHINE, A.SERIALNO, A.TRXDATE, IFNULL(B.LOTNUMBER,'') AS LOT1, IFNULL(C.LOTNUMBER,'') AS LOT2")
                        ->where([
                            ["A.LOCNCODE",$station],
                            ["A.MACHINE",$machine],
                        ])
                        ->whereBetween("A.TRXDATE",[$start,$end])
                        ->orderBy("A.TRXDATE","DESC")
                        ->paginate(10);

        return Response::json($results);
    }
}
