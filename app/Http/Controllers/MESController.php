<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mesData;
use App\mesClasses;
use App\mesStation;
use App\SerialInfo;
use App\Models\Planning\ProductionSchedule;
use Illuminate\Support\Facades\Auth;

use DB;
use DataTables;
use Response;

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

    public function dailyOutput($date) {
        $sched = ProductionSchedule::where("production_date",$date)->first();
        $shifts = $sched->selectedShifts;

        $daily = [];

        $od = date("Y-m-d",strtotime("1 days",strtotime($date)));
        
        foreach ($shifts as $shift) {
            $st = date("Y-m-d H:i:s",strtotime($date . $shift->details->start_time));
            $et = date("Y-m-d H:i:s",strtotime( ($shift->details->overday == 0 ? $date : $od) . $shift->details->end_time));

            $sh = "TRXDATE >= '" . $st . "' AND TRXDATE < '" . $et . "'";

            $sql = "SELECT '" . $shift->details->descr . "' AS SHIFT, IFNULL(A.PRODLINE, C.PRODLINE) AS PRODLINE, PRODTYPE, LOCNCODE, COUNT(A.SERIALNO) AS 'Total', ";

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
            $ix = 0;

            foreach($hrs as $hr) {
                $h = sprintf("%'.02d",$hr);
                
                if ($hr == 23) { 
                    $dt = date("Y-m-d",strtotime("-1 days",strtotime($dt)));
                }

                // if (date("YmdH",strtotime($dt . " " . $h.":00:00")) > date('YmdH')) { continue; }
                
                if ($ed == "") { $ed = $dt." ".$h.":59:59"; }
                $fd = $dt." ".$h.":00:00";

                $sq .= ($sq == "" ? "" : ", ") . "SUM(CASE WHEN TRXDATE BETWEEN '".$dt." ".$h.":00:00' AND '".$dt." ".$h.":59:59' THEN 1 ELSE 0 END) AS '".$h."'" ;
            }

            $sql .= $sq . " FROM mes01 A INNER JOIN lts02 B ON A.LOCNCODE = B.STNCODE INNER JOIN lbl02 C ON A.SERIALNO = C.SERIALNO AND C.LBLTYPE = 1 WHERE ".$sh." AND SORTIX IS NOT NULL GROUP BY IFNULL(A.PRODLINE, C.PRODLINE), PRODTYPE, LOCNCODE ORDER BY PRODTYPE, PRODLINE, SORTIX";

            $output = DB::connection('web_portal')
                            ->select($sql);

            array_push($daily, $output);
        }

        // return Datatables::of($output)->make(true);
        $data = [];

        $data['output'] = $daily;
        $data['date'] = $date;

        return view('mes.reports.output',$data);
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

        return view('mes.transactions.trx',$data);
        // return view('mes.reports.transactions');            
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
        $cclass = $serialInfo->MODCLASS == null || $serialInfo->MODCLASS == '' || $serialInfo->MODCLASS == 'null'  ? '' : $serialInfo->MODCLASS;
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
                        if ($cclass != $assignment->ALLOWCLS) {
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
