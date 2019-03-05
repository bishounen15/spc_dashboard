<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mesData;
use App\mesClasses;
use App\mesStation;
use App\SerialInfo;

use App\Models\WebPortal\DeviceAssignment;
use App\Station;

use App\Models\MFG\LamTransaction;
use App\Models\MFG\LamTransactionDetail;

use App\Models\Planning\ProductionSchedule;
use Illuminate\Support\Facades\Auth;

use DB;
use DataTables;
use Response;
use Validator;

class MESController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Manila');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('mes.reports.transactions');
    }

    public function load($start = '', $end = '')
    {
        $cond = [];

        // return $end;

        $sdate = $start == '' ? date('Y-m-d') : date('Y-m-d',strtotime($start));
        $edate = $end == '' ? date('Y-m-d') : date('Y-m-d',strtotime($end));

        $mes = DB::connection('web_portal')
                    ->select("SELECT A.SERIALNO, REPLACE(REPLACE(REPLACE(REPLACE(IFNULL(H.MODELNAME,E.PRODCODE),'[R]',CASE WHEN B.CELLCOLOR = 'E' AND B.CUSTOMER = 'GEN1' THEN 'M' ELSE B.CELLCOLOR END),'[C]',B.CELLCOUNT),'[P]',IFNULL(F.Bin,'XXX')),'[T]',IFNULL(B.CTYPE,'??')) AS MODEL, CONCAT('Line ',IFNULL(A.PRODLINE,B.PRODLINE)) AS PRODLINE, B.CUSTOMER, DATE_ADD(DATE(A.TRXDATE), INTERVAL CASE WHEN TIME(A.TRXDATE) < '06:00:00' THEN -1 ELSE 0 END DAY) AS 'DATE', A.TRXDATE, CONCAT('Shift ',CASE WHEN TIME(A.TRXDATE) BETWEEN '06:00:00' AND '13:59:59' THEN 'A' WHEN TIME(A.TRXDATE) BETWEEN '14:00:00' AND '21:59:59' THEN 'B' ELSE 'C' END) AS SHIFT, CASE A.SNOSTAT WHEN 0 THEN 'GOOD' WHEN 1 THEN 'MRB' ELSE 'SCRAP' END AS STATUS, A.REMARKS, A.MODCLASS, IFNULL(CONCAT(C.LASTNAME,', ',C.FIRSTNAME),D.USERNAME) AS USER, A.LOCNCODE FROM mes01 A INNER JOIN lbl02 B ON A.SERIALNO = B.SERIALNO AND B.LBLTYPE = 1 LEFT JOIN hri01 C ON A.TRXUID = C.IDNUMBER INNER JOIN sys01 D ON A.TRXUID = D.USERID LEFT JOIN cus01 E ON B.CUSTOMER = E.CUSCODE LEFT JOIN ftd_upd F ON B.SERIALNO = F.ModuleID LEFT JOIN lbl02 G ON A.SERIALNO = G.SERIALNO AND G.LBLTYPE = 3 LEFT JOIN lbt00 H ON G.CUSTOMER = H.CUSTOMER AND G.TEMPLATE = H.TMPCODE WHERE DATE_ADD(DATE(A.TRXDATE), INTERVAL CASE WHEN TIME(A.TRXDATE) < '06:00:00' THEN -1 ELSE 0 END DAY) BETWEEN ? AND ? ORDER BY A.ROWID DESC",[$sdate,$edate]);

        return Datatables::of($mes)->make(true);
    }

    public function transactions($date = '2018-09-23', $shift = 'A', $station = 0)
    {
        $stationInfo = mesStation::where('STNID',$station)->first();
        
        $mes = DB::connection('web_portal')
                    ->select("SELECT A.SERIALNO, REPLACE(REPLACE(REPLACE(REPLACE(IFNULL(H.MODELNAME,E.PRODCODE),'[R]',CASE WHEN B.CELLCOLOR = 'E' AND B.CUSTOMER = 'GEN1' THEN 'M' ELSE B.CELLCOLOR END),'[C]',B.CELLCOUNT),'[P]',IFNULL(F.Bin,'XXX')),'[T]',IFNULL(B.CTYPE,'??')) AS MODEL, CONCAT('Line ',IFNULL(A.PRODLINE,B.PRODLINE)) AS PRODLINE, B.CUSTOMER, DATE_ADD(DATE(A.TRXDATE), INTERVAL CASE WHEN TIME(A.TRXDATE) < '06:00:00' THEN -1 ELSE 0 END DAY) AS 'DATE', A.TRXDATE, CONCAT('Shift ',CASE WHEN TIME(A.TRXDATE) BETWEEN '06:00:00' AND '13:59:59' THEN 'A' WHEN TIME(A.TRXDATE) BETWEEN '14:00:00' AND '21:59:59' THEN 'B' ELSE 'C' END) AS SHIFT, CASE A.SNOSTAT WHEN 0 THEN 'GOOD' WHEN 1 THEN 'MRB' ELSE 'SCRAP' END AS STATUS, A.REMARKS, A.MODCLASS, IFNULL(CONCAT(C.LASTNAME,', ',C.FIRSTNAME),D.USERNAME) AS USER, A.LOCNCODE FROM mes01 A INNER JOIN lbl02 B ON A.SERIALNO = B.SERIALNO AND B.LBLTYPE = 1 LEFT JOIN hri01 C ON A.TRXUID = C.IDNUMBER INNER JOIN sys01 D ON A.TRXUID = D.USERID LEFT JOIN cus01 E ON B.CUSTOMER = E.CUSCODE LEFT JOIN ftd_upd F ON B.SERIALNO = F.ModuleID LEFT JOIN lbl02 G ON A.SERIALNO = G.SERIALNO AND G.LBLTYPE = 3 LEFT JOIN lbt00 H ON G.CUSTOMER = H.CUSTOMER AND G.TEMPLATE = H.TMPCODE WHERE DATE_ADD(DATE(A.TRXDATE), INTERVAL CASE WHEN TIME(A.TRXDATE) < '06:00:00' THEN -1 ELSE 0 END DAY) = ? AND CASE WHEN TIME(A.TRXDATE) BETWEEN '06:00:00' AND '13:59:59' THEN 'A' WHEN TIME(A.TRXDATE) BETWEEN '14:00:00' AND '21:59:59' THEN 'B' ELSE 'C' END = ? AND A.LOCNCODE = ? ORDER BY A.ROWID DESC",[$date,$shift,$stationInfo->STNCODE]);

        return Datatables::of($mes)->make(true);
    }

    public function dailyOutput($date = null) {
        if ($date == null) { $date = date('Y-m-d'); }
        $sched = ProductionSchedule::where("production_date",$date)->first();
        $shifts = $sched->selectedShifts;

        $daily = [];

        $od = date("Y-m-d",strtotime("1 days",strtotime($date)));
        
        foreach ($shifts as $shift) {
            $st = date("Y-m-d H:i:s",strtotime($date . $shift->details->start_time));
            $et = date("Y-m-d H:i:s",strtotime( ($shift->details->overday == 0 ? $date : $od) . $shift->details->end_time));

            $sh = "TRXDATE >= '" . $st . "' AND TRXDATE < '" . $et . "'";
            $eh = "CAST(CONCAT(B.ELDATE,' ',B.ELTIME) AS DATETIME) >= '" . $st . "' AND CAST(CONCAT(B.ELDATE,' ',B.ELTIME) AS DATETIME) < '" . $et . "'";

            $sql = "SELECT '" . $shift->details->descr . "' AS SHIFT, IFNULL(A.PRODLINE, C.PRODLINE) AS PRODLINE, PRODTYPE, LOCNCODE, COUNT(A.SERIALNO) AS 'Total' ";

            $dt = date("Y-m-d",strtotime($et));

            $fd = "";
            $ed = "";

            $hrs = [];

            $et = date("Y-m-d H:i:s",strtotime("-1 hour",strtotime($et)));
            while ($et >= $st) {
                array_push($hrs,date("H",strtotime($et)));
                $et = date("Y-m-d H:i:s",strtotime("-1 hour",strtotime($et)));
            }

            $sq = "";
            $sp = "";
            $se = "";
            $ls = "";
            $le = "";

            $ix = 0;
            $hi = 0;

            foreach($hrs as $hr) {
                $h = sprintf("%'.02d",$hr);
                
                if ($hr == 23) { 
                    $dt = date("Y-m-d",strtotime("-1 days",strtotime($dt)));
                }

                if (date("YmdH",strtotime($dt . " " . $h.":00:00")) > date('YmdH')) { continue; }
                if ($ed == "") { $ed = $dt." ".$h.":59:59"; }
                $fd = $dt." ".$h.":00:00";

                if ($hi < 4) {
                    $sq .= ", SUM(CASE WHEN TRXDATE BETWEEN '".$dt." ".$h.":00:00' AND '".$dt." ".$h.":59:59' THEN 1 ELSE 0 END) AS '".$h."'" ;
                } else {
                    if ($hi == 4) {
                        $se = "AND '".$dt." ".$h.":59:59' THEN 1 ELSE 0 END)";
                        $ls = $h;
                    }

                    $sp = ", SUM(CASE WHEN TRXDATE BETWEEN '".$dt." ".$h.":00:00' ";
                    $le = $h;
                }

                $hi++;
            }
            
            if ($sp != "") {
                $sp .= $se . " AS '".($ls==$le ? $ls : $ls."-".$le)."'";
            }

            $sql .= $sq . $sp . " FROM (SELECT PRODLINE, LOCNCODE, TRXDATE, SERIALNO FROM mes01 WHERE ".$sh." AND LOCNCODE NOT LIKE 'EL%' UNION ALL SELECT DISTINCT A.PRODLINE, A.MACHINE AS LOCNCODE, CAST(CONCAT(B.ELDATE,' ',B.ELTIME) AS DATETIME) AS TRXDATE, A.SERIALNO FROM elt01 A INNER JOIN elt02 B ON A.ROWID = B.ID WHERE ".$eh.") A INNER JOIN lts02 B ON A.LOCNCODE = B.STNCODE INNER JOIN lbl02 C ON A.SERIALNO = C.SERIALNO AND C.LBLTYPE = 1 WHERE SORTIX IS NOT NULL GROUP BY IFNULL(A.PRODLINE, C.PRODLINE), PRODTYPE, LOCNCODE ORDER BY PRODTYPE, PRODLINE, SORTIX";
            
            $output = DB::connection('web_portal')
                            ->select($sql);

            array_push($daily, $output);
        }

        $data = [];

        $data['output'] = $daily;
        $data['date'] = $date;
        $data['cdate'] = "";

        $cdate = date('Y-m-d',strtotime((date('H') < 6 ? "-1" : "0")." days",strtotime(date('Y-m-d'))));

        if ($date == $cdate) {
            $data['cdate'] = " as of " . date('H:i');
        }

        return view('mes.reports.output',$data);
    }

    public function lamValidation(Request $request) {
        $serial = $request->input('serial');
        
        $serialInfo = SerialInfo::where("SERIALNO",$serial)->first();
        
        $data = [];
        $data['errors'] = ['error_msg' => ''];

        if ($serialInfo != null) {
            if ($serialInfo->mes->last()->LOCNCODE != 'FG-PROD') {
                if ($serialInfo->mes->last()->LOCNCODE == "PRELAM") {
                    $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] is already scanned in '.$serialInfo->mes->last()->LOCNCODE.'.'];
                } else if ($serialInfo->mes->last()->LOCNCODE != 'EL1' && $serialInfo->mes->last()->LOCNCODE != 'EL3') {
                    $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] is already scanned post PRELAM.<br>Current Location is at ['.$serialInfo->mes->last()->LOCNCODE.']'];
                }
            } 
        } else {
            $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] does not exists.'];
        }

        if ($data['errors']['error_msg'] == '') {
            $data['SCANDATE'] = date("Y-m-d H:i:s");
        }

        return Response::json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($station)
    {
        //
        $data = [];

        $data['station'] = mesStation::where('STNID',$station)->first();
        
        $time = date('H:i');

        if ($time < date('H:i',strtotime('06:00'))) {
            $date = date('Y-m-d',strtotime('-1 days',strtotime('Today')));
        } else {
            $date = date('Y-m-d',strtotime('Today'));
        }

        $data['date'] = $date;

        if ($time >= date('H:i',strtotime('06:00')) && $time < date('H:i',strtotime('14:00'))) {
            $shift = 'A';
        } else if ($time >= date('H:i',strtotime('14:00')) && $time < date('H:i',strtotime('22:00'))) {
            $shift = 'B';
        } else {
            $shift = 'C';
        }

        $data['shift'] = $shift;

        if ($data["station"]->STNCODE == "PRELAM") {
            $lam_outs = DB::connection('mfg')->select("SELECT A.code as laminator, COUNT(C.serial_no) AS total, SUM(CASE IFNULL(C.location,'-') WHEN 'A' THEN 1 ELSE 0 END) AS 'A', SUM(CASE IFNULL(C.location,'-') WHEN 'B' THEN 1 ELSE 0 END) AS 'B', SUM(CASE IFNULL(C.location,'-') WHEN 'C' THEN 1 ELSE 0 END) AS 'C', SUM(CASE IFNULL(C.location,'-') WHEN 'D' THEN 1 ELSE 0 END) AS 'D' FROM sp_proddt.stations A LEFT JOIN sp_mfg.lam_transactions B ON A.id = B.station_id  LEFT JOIN sp_mfg.lam_transaction_details C ON B.id = c.trx_id AND C.date_scanned BETWEEN ? AND ? WHERE A.production_line = ? GROUP BY A.code",["2019-03-05 06:00:00","2019-03-05 17:59:59","1"]);

            $data['lam_outs'] = $lam_outs;

            $ip = $_SERVER['REMOTE_ADDR']?:($_SERVER['HTTP_X_FORWARDED_FOR']?:$_SERVER['HTTP_CLIENT_IP']);
            $prod_line = DeviceAssignment::where([
                ["IPADDRESS",$ip],
                ["STATION","PRELAM"],
            ])->first()->PRODLINE;

            $data["prod_line"] = $prod_line;
            $data["laminators"] = Station::select("stations.id","stations.code","stations.descr","stations.production_line")
                                    ->join("machines","stations.machine_id","machines.id")
                                    ->where([
                                        ["machines.descr","Laminator"],
                                        ["stations.production_line",$prod_line],
                                    ])->orderBy("stations.code","ASC")->get();

            return view('mes.transactions.lam.form',$data);
        } else {
            return view('mes.transactions.trx',$data);
        }
        // return view('mes.reports.transactions');            
    }

    public function createLamTrx(Request $request) {
        $data = [];

        $cno = DB::connection('mfg')->select("SELECT CONCAT(DATE_FORMAT(now(),'%Y%m'),LPAD(IFNULL(SUBSTR(MAX(control_no),7,6),0) + 1,6,0)) AS control_no FROM lam_transactions WHERE control_no LIKE CONCAT(DATE_FORMAT(now(),'%Y%m'),'%')");

        $lhead = [];
        $lhead['control_no'] = $cno[0]->control_no;
        $lhead['station_id'] = $request->input('STATIONID');
        $SERIALNO = $request->input('SERIALNO');

        $snos = explode(',',$SERIALNO[0]);

        $validator = Validator::make($lhead, [
            'control_no' => 'required|unique:mfg.lam_transactions',
        ]);

        $serr = [];
        $ix = 0;
        $field_names = ['location','serial_no','date_scanned'];
        $sd = ["location" => "","serial_no" => "", "date_scanned" => ""];

        $req = [];

        if ($validator->fails()) {
            array_push($serr, $lhead['control_no']." already exists.");
        } else {
            foreach($snos as $key => $value) {
                $sd[$field_names[$ix]] = $value;
                $ix++;

                if ($ix >= count($field_names)) {
                    $validator = Validator::make($sd, [
                        'serial_no' => 'unique:mfg.lam_transaction_details',
                    ]);

                    if ($validator->fails()) {
                        array_push($serr,$sno." already exists.");
                    } else {
                        array_push($req, $sd);
                    }

                    $ix = 0;
                }
            }
        }
        
        $data['errors'] = $serr;

        if (count($serr) == 0) {
            $trx = LamTransaction::create($lhead);
            
            foreach($req as $r) {
                $details = [];
                $details["serial_no"] = $r['serial_no'];
                $details["location"] = $r['location'];
                $details["date_scanned"] = $r['date_scanned'];
                $details["trx_id"] = $trx->id;
                
                LamTransactionDetail::create($details);

                // $info = SerialInfo::selectRaw("(SELECT CONCAT(DATE_FORMAT(now(),'%Y%m'),LPAD(SUBSTR(MAX(MESCNO),7,6) + 1,6,0)) AS MESCNO FROM spmmc00.mes01 WHERE MESCNO LIKE CONCAT(DATE_FORMAT(now(),'%Y%m'),'%')) AS CNO, lbl02.MODCLASS, cls01.MODSTATUS")
                //             ->join("cls01", function ($join) {
                //                 $join->on("lbl02.MODCLASS","=","cls01.MCLCODE"); 
                //                 $join->on("lbl02.CUSTOMER","=","cls01.CUSTOMER");
                //             })->where([
                //                 ["lbl02.SERIALNO",$sno],
                //                 ["lbl02.LBLTYPE",1]
                //             ])->first();

                $cno = DB::connection('web_portal')->select("SELECT CONCAT(DATE_FORMAT(now(),'%Y%m'),LPAD(IFNULL(SUBSTR(MAX(MESCNO),7,6),0) + 1,6,0)) AS MESCNO FROM mes01 WHERE MESCNO LIKE CONCAT(DATE_FORMAT(now(),'%Y%m'),'%')");

                $mescno = $cno[0]->MESCNO;

                mesData::insert([
                    'SERIALNO' => $r['serial_no'],
                    'LOCNCODE' => 'PRELAM',
                    'MODCLASS' => '',
                    'SNOSTAT' => '0',
                    'REMARKS' => 'Good',
                    'MESCNO' => $mescno,
                    'TRXUID' => Auth::user()->user_id,
                    'TRXDATE' => $r['date_scanned'],
                ]);
            }
        }

        return Response::json($data);
    }

    public function serialValidation(Request $request) {
        $serial = $request->input('serial');
        $station = $request->input('station');

        $assignment = Auth::user()->portalUser->mesUser->assignment->where('STNCODE',$station)->first();

        $data = [];

        $data['errors'] = ['error_msg' => ''];
        $data['serial'] = [];

        $mes = mesData::where('SERIALNO',$serial)
                            ->orderBy('ROWID','DESC')
                            ->first();

        $serialInfo = SerialInfo::where('SERIALNO',$serial)->first();
        $stationInfo = mesStation::where('STNCODE',DB::raw("'".$station."'"))->first();
        $cclass = $serialInfo == null ? '' : ($serialInfo->MODCLASS == null || $serialInfo->MODCLASS == '' || $serialInfo->MODCLASS == 'null'  ? '' : $serialInfo->MODCLASS);
        $fill_serial = false;

        $recent_loc = $mes == null ? 'Not yet scanned' : $mes->LOCNCODE;

        if ($serialInfo != null) {
            if ($assignment->UNISNO == 1) {
                if ($recent_loc == $station) {
                    $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] already within the current location.'];
                } else {
                    if ($stationInfo->routing->where('SRCLOC',$recent_loc)->first() == null) {
                        if ($stationInfo->INITLOC == 0 || ($stationInfo->INITLOC == 1 && $recent_loc != 'Not yet scanned')) {
                            $data['errors'] = ['error_msg' => 'You cannot transact this serial number ['.$serial.'] in this location. (Current Location: '.$recent_loc.')'];
                        } else {
                            $fill_serial = true;    
                        }
                    } else {
                        if ((strpos($cclass, $assignment->ALLOWCLS) !== false) == false) {
                            $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] is not Class '.$assignment->ALLOWCLS.'. (Current Class: '.$serialInfo->MODCLASS.')'];
                        } else {
                            $fill_serial = true;
                        }
                    }
                }
            } else {
                $fill_serial = true;
            }
        } else {
            $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] does not exists.'];
        }

        if ($fill_serial == true) {
            $classes = mesClasses::where('CUSTOMER',$serialInfo->CUSTOMER)->get(); 

            $class = [
                '0' => $classes->where('MODSTATUS',0),
                '1' => $classes->where('MODSTATUS',1),
                '2' => $classes->where('MODSTATUS',2),
                '3' => $classes,
                '4' => $classes->where('MODSTATUS',0),
            ];

            $data['serial'] = [
                'serialno' => $serialInfo->SERIALNO,
                'customer' => $serialInfo->CUSTOMER,
                'model' => $serialInfo->modelName(),
                'class' => $serialInfo->MODCLASS == '' && $mes == null ? 'A' : $serialInfo->MODCLASS,
                'class_list' => $class,
                'station' => $recent_loc,
                'statusCode' => $mes == null ? 0 : $mes->SNOSTAT,
                'status' => $mes == null ? 'GOOD' : strtoupper($mes->moduleStatus()),
                'remarks' => $mes == null ? '' : $assignment->ALLOWCLS == '' ? $mes->REMARKS : "Endorsed to " . $assignment->stationInfo->STNDESC,
                'allowcls' => $assignment->ALLOWCLS,
            ];
        }

        return Response::json($data);
    }

    public function generateControl() {
        $pfx = date('Ym');
        $last_trx = mesData::where('MESCNO','LIKE',DB::raw("'".$pfx."%'"))->orderBy('ROWID','DESC')->first();

        if ($last_trx != null) {
            $cid = substr($last_trx->MESCNO,6,6);
            $cno = trim($pfx) . sprintf("%'.06d",((int)$cid) + 1);
        } else {
            $cno = trim($pfx) . sprintf("%'.06d\n",(0 + 1));
        }

        return $cno;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $station)
    {
        //
        $serial = $request->input('SERIALNO');
        $location = mesStation::where('STNID',$station)->first()->STNCODE;
        $class = $request->input('MODCLASS');
        $status = $request->input('SNOSTAT');
        $remarks = $request->input('REMARKS');

        $cno = $this->generateControl();

        mesData::insert([
            'SERIALNO' => $serial,
            'LOCNCODE' => $location,
            'MODCLASS' => $class,
            'SNOSTAT' => $status,
            'REMARKS' => $remarks,
            'MESCNO' => $cno,
            'TRXUID' => Auth::user()->user_id,
            'TRXDATE' => DB::raw('now()'),
        ]);

        return Response::json(['cno' => $cno, 'location' => $location]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
