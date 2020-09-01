<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Request as Req;

use App\ftdData;
use App\mesData;
use App\mesClasses;
use App\mesStation;
use App\SerialInfo;
use App\portalCustomer;
use App\Models\Planning\ProductionSchedule;
use App\Models\WebPortal\OEMCondition;
use App\Models\WebPortal\ProductionLine;
use App\Models\WebPortal\IPAssign;
use App\Models\WebPortal\MESAdditional;
use Illuminate\Support\Facades\Auth;

use DB;
use DataTables;
use Response;

use Validator;
use Illuminate\Validation\Rule;

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

        $sdate = ($start == null ? date('Y-m-d') : date('Y-m-d',strtotime($start)))  . " 06:00:00";
        $edate = date('Y-m-d',strtotime("+1 days",strtotime(($end == null ? "Today" : $end)))) . " 05:59:59";

        // $sdate = $start == '' ? date('Y-m-d') : date('Y-m-d',strtotime($start));
        // $edate = $end == '' ? date('Y-m-d') : date('Y-m-d',strtotime($end));

        $mes = DB::connection('web_portal')
                    ->select("SELECT A.SERIALNO, CONCAT(REPLACE(REPLACE(REPLACE(REPLACE(IFNULL(IFNULL(I.PRODCODE, H.MODELNAME),E.PRODCODE),'[R]',CASE WHEN B.CELLCOLOR = 'E' AND B.CUSTOMER = 'GEN1' THEN 'M' ELSE B.CELLCOLOR END),'[C]',B.CELLCOUNT),'[P]',IFNULL(IFNULL(J.BIN,F.Bin),'XXX')),'[T]',IFNULL(B.CTYPE,'??')),CASE IFNULL(L.REMARKS,'') WHEN '' THEN '' ELSE CONCAT(' (',L.REMARKS,')') END) AS MODEL, K.LINDESC AS PRODLINE, B.CUSTOMER, DATE_ADD(DATE(A.TRXDATE), INTERVAL CASE WHEN TIME(A.TRXDATE) < '06:00:00' THEN -1 ELSE 0 END DAY) AS 'DATE', A.TRXDATE, CONCAT('Shift ',CASE WHEN TIME(A.TRXDATE) BETWEEN '06:00:00' AND '13:59:59' THEN 'A' WHEN TIME(A.TRXDATE) BETWEEN '14:00:00' AND '21:59:59' THEN 'B' ELSE 'C' END) AS SHIFT, CASE A.SNOSTAT WHEN 0 THEN 'GOOD' WHEN 1 THEN 'MRB' ELSE 'SCRAP' END AS STATUS, A.REMARKS, A.MODCLASS, IFNULL(CONCAT(C.LASTNAME,', ',C.FIRSTNAME),D.USERNAME) AS USER, A.LOCNCODE FROM mes01 A INNER JOIN lbl02 B ON A.SERIALNO = B.SERIALNO AND B.LBLTYPE = 1 INNER JOIN lin01 K ON IFNULL(A.PRODLINE,B.PRODLINE) = K.LINCODE LEFT JOIN hri01 C ON A.TRXUID = C.IDNUMBER INNER JOIN sys01 D ON A.TRXUID = D.USERID LEFT JOIN cus01 E ON B.CUSTOMER = E.CUSCODE LEFT JOIN ftd_upd F ON B.SERIALNO = F.ModuleID LEFT JOIN lbl02 G ON A.SERIALNO = G.SERIALNO AND G.LBLTYPE = 3 LEFT JOIN lbt00 H ON G.CUSTOMER = H.CUSTOMER AND G.TEMPLATE = H.TMPCODE LEFT JOIN typ00 I ON B.PRODTYPE = I.PRODTYPE LEFT JOIN bin00 J ON I.PRODTYPE = J.PRODTYPE AND I.CUSTOMER = J.CUSTOMER AND (F.Pmpp >= J.MINPMPP AND F.Pmpp < J.MAXPMPP) LEFT JOIN wor01 L ON B.ORDERNO = L.WOID WHERE A.TRXDATE BETWEEN ? AND ? ORDER BY A.ROWID DESC",[$sdate,$edate]);

        return Datatables::of($mes)->make(true);
    }

    public function testOuts($date = null)
    {
        $cond = [];
        $ts = [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 0, 1, 2, 3, 4, 5];
        $sql = '';

        $sdate = ($date == null ? date('Y-m-d') : date('Y-m-d',strtotime($date)))  . " 06:00:00";
        $edate = date('Y-m-d',strtotime("+1 days",strtotime(($date == null ? "Today" : $date)))) . " 05:59:59";

        foreach($ts as $t) {
            $s1 = $t;
            $e1 = ($t == 23 ? 0 : $t + 1);

            $st = ($s1 < 10 ? "0" : "") . $s1;
            $et = ($e1 < 10 ? "0" : "") . $e1;

            $sd = date('Y-m-d',strtotime(($s1 < 6 ? $edate : $sdate)));
            $ed = date('Y-m-d',strtotime(($e1 < 6 ? $edate : $sdate)));

            $sql .= ", SUM(CASE WHEN F.DTCREATE BETWEEN '" . $sd . " " . $st . ":00:00' AND '" . $ed . " " . $et . ":00:00' THEN 1 ELSE 0 END) AS '" . $st . "'";
        }

        // dd($sql);

        $testouts = DB::connection('web_portal')
                    ->select("SELECT E.NSWO, F.PRODUCTNO AS PARTNO, F.MODELNAME AS MODEL, B.BOM, COUNT(*) AS TOTAL".$sql." FROM epl02 A INNER JOIN epl01 F ON A.PALLETNO = F.PALLETNO AND A.CARTONNO = F.CARTONNO INNER JOIN lbl02 B ON A.SERIALNO = B.SERIALNO AND B.LBLTYPE = 1 INNER JOIN typ00 C ON B.PRODTYPE = C.PRODTYPE LEFT JOIN itm01 D ON F.PRODUCTNO = D.ITMCODE LEFT JOIN wor02 E ON B.ORDERNO = E.WOID AND B.BOM = E.REVNO AND D.ITMCODE = E.PARTNO AND B.PRODLINE = E.PRODLINE WHERE F.DTCREATE BETWEEN ? AND ? AND A.PALLETNO NOT LIKE 'MRB%' GROUP BY E.NSWO, F.PRODUCTNO, F.MODELNAME, B.BOM ORDER BY PARTNO, MODEL, BOM",[$sdate,$edate]);

        return Datatables::of($testouts)->make(true);
    }

    public function transactions($date = '2018-09-23', $shift = 'A', $station = 0, $line = null)
    {
        $stationInfo = mesStation::where('STNID',$station)->first();
        $values = [$date,$shift,$stationInfo->STNCODE];
        
        if ($line != null) {
            array_push($values,$line);
        }

        $mes = DB::connection('web_portal')
                    ->select("SELECT A.SERIALNO, REPLACE(REPLACE(REPLACE(REPLACE(IFNULL(IFNULL(I.PRODCODE, H.MODELNAME),E.PRODCODE),'[R]',CASE WHEN B.CELLCOLOR = 'E' AND B.CUSTOMER = 'GEN1' THEN 'M' ELSE B.CELLCOLOR END),'[C]',B.CELLCOUNT),'[P]',IFNULL(IFNULL(J.BIN,F.Bin),'XXX')),'[T]',IFNULL(B.CTYPE,'??')) AS MODEL, K.LINDESC AS PRODLINE, B.CUSTOMER, DATE_ADD(DATE(A.TRXDATE), INTERVAL CASE WHEN TIME(A.TRXDATE) < '06:00:00' THEN -1 ELSE 0 END DAY) AS 'DATE', A.TRXDATE, CONCAT('Shift ',CASE WHEN TIME(A.TRXDATE) BETWEEN '06:00:00' AND '13:59:59' THEN 'A' WHEN TIME(A.TRXDATE) BETWEEN '14:00:00' AND '21:59:59' THEN 'B' ELSE 'C' END) AS SHIFT, CASE A.SNOSTAT WHEN 0 THEN 'GOOD' WHEN 1 THEN 'MRB' ELSE 'SCRAP' END AS STATUS, A.REMARKS, A.MODCLASS, IFNULL(CONCAT(C.LASTNAME,', ',C.FIRSTNAME),D.USERNAME) AS USER, A.LOCNCODE FROM mes01 A INNER JOIN lbl02 B ON A.SERIALNO = B.SERIALNO AND B.LBLTYPE = 1 INNER JOIN lin01 K ON IFNULL(A.PRODLINE,B.PRODLINE) = K.LINCODE LEFT JOIN hri01 C ON A.TRXUID = C.IDNUMBER INNER JOIN sys01 D ON A.TRXUID = D.USERID LEFT JOIN cus01 E ON B.CUSTOMER = E.CUSCODE LEFT JOIN ftd_upd F ON B.SERIALNO = F.ModuleID LEFT JOIN lbl02 G ON A.SERIALNO = G.SERIALNO AND G.LBLTYPE = 3 LEFT JOIN lbt00 H ON G.CUSTOMER = H.CUSTOMER AND G.TEMPLATE = H.TMPCODE LEFT JOIN typ00 I ON B.PRODTYPE = I.PRODTYPE LEFT JOIN bin00 J ON I.PRODTYPE = J.PRODTYPE AND I.CUSTOMER = J.CUSTOMER AND (F.Pmpp >= J.MINPMPP AND F.Pmpp < J.MAXPMPP) WHERE DATE_ADD(DATE(A.TRXDATE), INTERVAL CASE WHEN TIME(A.TRXDATE) < '06:00:00' THEN -1 ELSE 0 END DAY) = ? AND CASE WHEN TIME(A.TRXDATE) BETWEEN '06:00:00' AND '13:59:59' THEN 'A' WHEN TIME(A.TRXDATE) BETWEEN '14:00:00' AND '21:59:59' THEN 'B' ELSE 'C' END = ? AND A.LOCNCODE = ?" . ($line == null ? "" : " AND IFNULL(A.PRODLINE,B.PRODLINE) = ?") . " ORDER BY A.ROWID DESC",$values);

        // return Datatables::of($mes)->make(true);
        return Response::json(["data" => $mes]);
    }

    public function dailyOutput($date = null) {
        if ($date == null) { $date = date('Y-m-d'); }
        $sched = ProductionSchedule::where("production_date",$date)->first();

        if ($sched == null) {
            $sched = ProductionSchedule::where("activity","!=","Restday")->orderBy("production_date","desc")->first();
        }

        $shifts = $sched->selectedShifts;

        $daily = [];

        $od = date("Y-m-d",strtotime("1 days",strtotime($date)));
        
        foreach ($shifts as $shift) {
            $st = date("Y-m-d H:i:s",strtotime($date . $shift->details->start_time));
            $et = date("Y-m-d H:i:s",strtotime( ($shift->details->overday == 0 ? $date : $od) . $shift->details->end_time));

            $sh = "TRXDATE >= '" . $st . "' AND TRXDATE < '" . $et . "'";
            $eh = "CAST(CONCAT(B.ELDATE,' ',B.ELTIME) AS DATETIME) >= '" . $st . "' AND CAST(CONCAT(B.ELDATE,' ',B.ELTIME) AS DATETIME) < '" . $et . "'";

            $sql = "SELECT '" . $shift->details->descr . "' AS SHIFT, D.LINDESC AS PRODLINE, CONCAT(C.PRODTYPE, CASE IFNULL(E.REMARKS,'') WHEN '' THEN '' ELSE CONCAT(' (',E.REMARKS,')') END) AS PRODTYPE, LOCNCODE, COUNT(A.SERIALNO) AS 'Total' ";

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

            $sql .= $sq . $sp . " FROM (SELECT DISTINCT PRODLINE, LOCNCODE, TRXDATE, SERIALNO FROM mes01 WHERE ".$sh." AND LOCNCODE NOT LIKE 'EL%' UNION ALL SELECT DISTINCT A.PRODLINE, A.MACHINE AS LOCNCODE, CAST(CONCAT(B.ELDATE,' ',B.ELTIME) AS DATETIME) AS TRXDATE, A.SERIALNO FROM elt01 A INNER JOIN elt02 B ON A.ROWID = B.ID WHERE ".$eh.") A INNER JOIN lts02 B ON A.LOCNCODE = B.STNCODE INNER JOIN lbl02 C ON A.SERIALNO = C.SERIALNO AND C.LBLTYPE = 1 INNER JOIN lin01 D ON IFNULL(A.PRODLINE, C.PRODLINE) = D.LINCODE LEFT JOIN wor01 E ON C.ORDERNO = E.WOID WHERE SORTIX IS NOT NULL GROUP BY IFNULL(A.PRODLINE, C.PRODLINE), D.LINDESC, PRODTYPE, LOCNCODE ORDER BY PRODLINE, PRODTYPE, SORTIX";
            
            $output = DB::connection('web_portal')
                            ->select($sql);

            // dd($sql);

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

    public function ftd() {
        $customers = DB::connection('web_portal')
                            ->table('cus01')
                            ->select('CUSCODE AS CODE','CUSDESC AS DESC')
                            ->get();

        $data = [];
        $data['customers'] = $customers;

        return view('mes.reports.ftd',$data);
    }

    public function ftdReport(Request $request) {
        $cond = '';
        $param = $request->input('param');

        if ($param == 'pallet') {
            $pallets = $request->input('palletno');
            $pnos = explode(",",$pallets . ",");
            
            $cond = "X.PALLETNO IN (";

            foreach($pnos as $pno) {
                $cond .= ($pno !="" ? ($cond == 'X.PALLETNO IN (' ? '' : ',') . "'" . $pno . "'" : "");
            }

            $cond .= ")";
        } else {
            $start = $request->input('start');
            $end = $request->input('end');

            $start = ($start == null ? date('Y-m-d') : date('Y-m-d',strtotime($start)))  . " 06:00:00";
            $end = date('Y-m-d',strtotime("+1 days",strtotime(($end == null ? "Today" : $end)))) . " 05:59:59";

            $cond = "IFNULL(DATE_ADD(X.TRXDATE, INTERVAL 6 HOUR),Y.InspectionTime) BETWEEN '".$start."' AND '".$end."'";
            $cond .= " AND W.CUSTOMER = '".$request->input('customer')."'";

            $type = $request->input('type');

            if ($type == 'standard') {
                $cond .= " AND X.PALLETNO NOT LIKE 'MRB%'";
            } else if ($type == 'mrb') {
                $cond .= " AND X.PALLETNO LIKE 'MRB%'";
            }
        }

        $sql = "SELECT X.PALLETNO AS 'PalletNo', X.CARTONNO AS 'CartonNo', DATE_FORMAT(TRXDATE,'%Y-%m-%d') AS 'Date', PRODUCTNO AS 'ProductNo', MODELNAME AS 'ModelName', SEQNO AS 'SeqNo', Y.ModuleID AS 'SerialNo', CASE IFNULL(W.MODCLASS,'') WHEN '' THEN 'A' ELSE W.MODCLASS END AS 'ModuleClass', IFNULL(GENDESC, CASE X.CUSTOMER WHEN 'ASTRO' THEN CASE WHEN IFNULL(Y.Impp,0) >= X.LOWRATE AND IFNULL(Y.Impp,0) < X.MIDRATE THEN 'L' ELSE 'H' END WHEN 'JA ' THEN CASE WHEN IFNULL(Y.Impp,0) < X.LOWRATE THEN 'L' WHEN IFNULL(Y.Impp,0) > X.HIGHRATE THEN 'H' ELSE 'M' END ELSE '-' END) AS 'Remarks', Y.InspectionTime AS 'TestDate', IFNULL(Y.Bin,0) AS 'Bin', IFNULL(Y.Pmpp,0) AS 'Power', IFNULL(Y.Uoc,0) AS 'Voc', IFNULL(Y.Isc,0) AS 'Isc', IFNULL(Y.Umpp,0) AS 'Vmp', IFNULL(Y.Impp,0) AS 'Imp', IFNULL(Y.ShuntResistance,0) AS 'Rsh', IFNULL(Y.FF,0)AS 'FF', X.PALLETSNO, Z.CABINETNO AS 'ContainerNo' FROM (SELECT CASE A.PALLETNO WHEN @PALLETNO THEN CASE A.CARTONNO WHEN @CARTONNO THEN @curRow := @curRow + 1 ELSE @curRow := 1 END ELSE @curRow :=1 END AS SEQNO, B.SERIALNO, @PALLETNO := A.PALLETNO AS PALLETNO, @CARTONNO := A.CARTONNO AS CARTONNO, A.PRODUCTNO, A.MODELNAME, C.GENDESC, A.TRXDATE, IFNULL(D.LOWRATE,0) AS LOWRATE, IFNULL(D.MIDRATE,0) AS MIDRATE, IFNULL(D.HIGHRATE,0) AS HIGHRATE, A.CUSTOMER, A.ROWID, A.PALLETSNO FROM epl01 A INNER JOIN epl02 B ON A.PALLETNO = B.PALLETNO AND A.CARTONNO = B.CARTONNO LEFT JOIN itm01 C ON A.PRODUCTNO = C.ITMCODE LEFT JOIN fdd01 D ON A.MODELNAME LIKE D.MODCODE AND CASE A.CUSTOMER WHEN 'ASTRO' THEN RIGHT(A.MODELNAME,3) WHEN 'JA' THEN SUBSTRING(A.MODELNAME,12,3) ELSE 0 END = D.POWRATE JOIN (SELECT @curRow := 0, @PALLETNO := '', @CARTONNO := '') r) X RIGHT JOIN ftd_upd Y ON X.SERIALNO = Y.ModuleID LEFT JOIN cab02 Z ON X.PALLETNO = Z.PALLETNO INNER JOIN lbl02 W ON Y.ModuleID = W.SERIALNO AND W.LBLTYPE = 1 WHERE ".$cond." ORDER BY W.CUSTOMER, Z.CABINETNO, X.ROWID, X.PALLETNO, X.CARTONNO, X.SEQNO, Y.InspectionTime";

        $ftd = DB::connection('web_portal')
                            ->select($sql);

        return Response::json($ftd);
    }

    public function resetPower($serial,$rowid) {
        $sno = str_replace('*','',$serial);
        $ftd = ftdData::where("ModuleID","LIKE",$sno."%")->orderBy('ROWID','desc')->get();

        foreach($ftd as $ft) {
            $ft->ModuleID = str_replace('*','',$ft->ModuleID) . ($ft->ROWID > $rowid ? '*' : '');
            $saved = $ft->save();
        }

        return Response::json($sno);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($station,$line = null)
    {
        //
        $data = [];

        $data['station'] = mesStation::where('STNID',$station)->first();
        $data['prodline'] = $line;

        $line_info = ProductionLine::where("LINCODE",$line)->first();

        $data['registration'] = $line == null ? "" : $line_info->LINCAT;
        $data['linedesc'] = $line == null ? "" : $line_info->LINDESC;

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

        return view('mes.vue.mes',$data);
        // return view('mes.transactions.trx',$data);
    }

    public function serialValidation(Request $request, $line = null) {
        $serial = $request->input('serial');
        $station = $request->input('station');

        $line_assign = IPAssign::where("IPADDRESS",Req::ip())->first();
        if ($line_assign != null) {
            $registration = $line_assign->prodLine()->LINCAT;
        } else {
            $registration = null;
        }

        $assignment = Auth::user()->portalUser->mesUser->assignment->where('STNCODE',$station)->first();

        $data = [];

        $data['errors'] = ['error_msg' => ''];
        $data['serial'] = [];

        $params = [
            ['LOCNCODE',$station],
        ];

        if ($line != null) {
            array_push($params,["PRODLINE",$line]);
        }

        $last_mes = mesData::where($params)
                                ->orderBy('TRXDATE','DESC')
                                ->first();
        $cond = null;
        if ($last_mes != null) {
            $cond = OEMCondition::where([
                ["CUSTOMER", $last_mes->serial->first()->CUSTOMER],
                ["STATION", $station],
            ])->first();
        }

        $custom_error = false;
        $trx_count = 0;

        if ($cond != null) {
            $check = DB::connection($cond->CONN)->select("SELECT COUNT(*) AS TRX FROM ".$cond->TABLE_NAME." WHERE ".$cond->FIELD_NAME." = ?" . $cond->ADDCOND,[$last_mes->SERIALNO]);
            $trx_count = $check[0]->TRX;
            // dd($trx_count);
            if ($check[0]->TRX == 0 && $last_mes->MODCLASS <> 'Q1') {
                eval($cond->ERR_MSG);

                if ($e_msg <> "") {
                    $data['errors'] = ['error_msg' => $e_msg];
                    $custom_error = true;
                }
            }
        }

        if ($custom_error == false) {
            $mes = mesData::where('SERIALNO',$serial)
                                ->orderBy('TRXDATE','DESC')
                                ->first();

            $serialInfo = SerialInfo::where('SERIALNO',$serial)->first();
            $stationInfo = mesStation::where('STNCODE',DB::raw("'".$station."'"))->first();
            $cclass = $serialInfo == null ? '' : ($serialInfo->MODCLASS == null || $serialInfo->MODCLASS == '' || $serialInfo->MODCLASS == 'null'  ? '' : $serialInfo->MODCLASS);
            $fill_serial = false;

            // $recent_loc = $mes == null ? 'Not yet scanned' : $mes->LOCNCODE;
            $recent_loc = $mes == null ? 'Not yet scanned' : $serialInfo->CURRENTLOC;
            
            if ($serialInfo != null) {
                $rou = DB::connection('web_portal')
                            ->table("rou01")
                            ->where([
                                ["STNID",$stationInfo->STNID],
                                ["CUSTSKIP","LIKE","%".$serialInfo->CUSTOMER."%"],
                            ]);
                $scode = $rou->count() > 0 ? $rou->first()->SRCLOC : "";
                $skip = $rou->count();

                $stn = null;

                while ($skip > 0) {
                    $stn = DB::connection('web_portal')
                                ->table("lts02")
                                ->where([
                                    ["STNCODE",$scode]
                                ])->first();

                    unset($rou);
                    $rou = DB::connection('web_portal')
                            ->table("rou01")
                            ->where([
                                ["STNID",$stn->STNID],
                                ["CUSTSKIP","LIKE","%".$serialInfo->CUSTOMER."%"],
                            ]);
                    
                    if ($rou->count() > 0) {
                        $scode = $rou->first()->SRCLOC;
                        $skip = $rou->count();
                    } else {
                        $skip = 0;
                    }
                }

                $rou = DB::connection('web_portal')
                            ->table("rou01")
                            ->where("STNID",$stn == null ? $stationInfo->STNID : $stn->STNID)
                            ->first();
            }

            if ($serialInfo != null) {
                if ($assignment->UNISNO == 1) {
                    if ($recent_loc == $station) {
                        $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] already within the current location.'];
                    } else {
                        // 
                        if ($stationInfo->routing->where('SRCLOC',$recent_loc)->first() == null) {
                            if (($rou !== null && $rou->SRCLOC != $recent_loc) || ($rou == null && $recent_loc != 'Not yet scanned')) {
                                $data['errors'] = ['error_msg' => 'You cannot transact this serial number ['.$serial.'] in this location. (Current Location: '.$recent_loc.')'];
                            } else {
                                $fill_serial = true;    
                            }
                        } else {
                            if ($assignment->ALLOWCLS != "") {
                                if ((strpos($cclass, $assignment->ALLOWCLS) !== false) == false) {
                                    $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] is not Class '.$assignment->ALLOWCLS.'. (Current Class: '.$serialInfo->MODCLASS.')'];
                                } else {
                                    $fill_serial = true;
                                }
                            } else {
                                $fill_serial = true;
                            }
                        }
                        
                        if ($fill_serial == true) {
                            if ($registration != null) {
                                if ($serialInfo->workOrder() != null) {
                                    $reg = $serialInfo->workOrder()->WOCATEGORY;
                                } else {
                                    $reg = ProductionLine::where("LINCODE",$serialInfo->PRODLINE)->first()->LINCAT;
                                }
    
                                if ($registration != $reg) {
                                    $data['errors'] = ['error_msg' => 'The serial number ['.$serial.'] is under ' . $reg . ' registration.'];
                                    $fill_serial = false;
                                } else {
                                    $fill_serial = true;
                                }
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

                $warn = "";

                if ($cond != null) {
                    if ($cond->CLASS_ALLOW == "" && $trx_count == 0) {
                        $warn = $cond->WARNING_MSG;
                    } else if ($cond->CLASS_ALLOW != "") {
                        $warn = $cond->WARNING_MSG;
                    }
                }

                $init_class = DB::connection('web_portal')
                                    ->table('cls01')
                                    ->select("MCLCODE AS class")
                                    ->where("CUSTOMER",$serialInfo->CUSTOMER)
                                    ->first()->class;

                $data['serial'] = [
                    'serialno' => $serialInfo->SERIALNO,
                    'customer' => $serialInfo->CUSTOMER,
                    'model' => $serialInfo->modelName(),
                    'class' => $serialInfo->MODCLASS == '' && $mes == null ? $init_class : $serialInfo->MODCLASS,
                    'class_list' => $class,
                    'station' => $recent_loc,
                    'statusCode' => $mes == null ? 0 : $mes->SNOSTAT,
                    'status' => $mes == null ? 'GOOD' : strtoupper($mes->moduleStatus()),
                    'remarks' => $mes == null ? 'GOOD' : ($assignment->ALLOWCLS == '' ? $mes->REMARKS : "Endorsed to " . $assignment->stationInfo->STNDESC),
                    'allowcls' => $assignment->ALLOWCLS,
                    'custclass' => $cond != null ? $cond->CLASS_ALLOW : "",
                    'warning' => $warn,
                    'source_station' => $rou != null ? $rou->SRCLOC : "",
                    'auto_save' => $auto_save,
                ];
            }
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
    public function store(Request $request, $station, $line = null)
    {
        //
        $serial = $request->input('SERIALNO');
        $location = mesStation::where('STNID',$station)->first()->STNCODE;
        $class = $request->input('MODCLASS');
        $status = $request->input('SNOSTAT');
        $remarks = $request->input('REMARKS');

        $cno = $this->generateControl();

        $data = [];

        $data['SERIALNO'] = $serial;
        $data['LOCNCODE'] = $location;
        $data['MODCLASS'] = $class;
        $data['SNOSTAT'] = $status;
        $data['REMARKS'] = $remarks;
        $data['MESCNO'] = $cno;
        $data['TRXUID'] = Auth::user()->user_id;
        $data['TRXDATE'] = DB::raw('now()');

        if ($line != null) {
            $data['PRODLINE'] = $line;
        }

        mesData::insert($data);

        return Response::json(['cno' => $cno, 'location' => $location]);
    }

    public function mesDups() {
        $locs = mesStation::whereRaw("SORTIX IS NOT NULL")->orderBy("SORTIX","ASC")->select("STNCODE")->get();
        $data = [];
        $data['locs'] = $locs;

        return view('mes.reports.dups', $data);
    }

    public function loadDups($start, $end, $location) {
        $sdate = date('Y-m-d',strtotime($start))  . " 06:00:00";
        $edate = date('Y-m-d',strtotime("+1 days",strtotime($end))) . " 05:59:59";

        $results = DB::connection('web_portal')->select("SELECT A.ROWID, A.SERIALNO, A.LOCNCODE, D.LINDESC AS PRODLINE, A.TRXDATE, A.TRXUID, B.USERNAME, (SELECT CONCAT(LOCNCODE, ': ', DATE_FORMAT(TRXDATE,'%Y-%m-%d %H:%i:%s')) AS NEXT_TRX FROM mes01 WHERE SERIALNO = A.SERIALNO AND TRXDATE > A.TRXDATE LIMIT 1) AS NEXT_LOC FROM mes01 A INNER JOIN sys01 B ON A.TRXUID = B.USERID INNER JOIN lbl02 C ON A.SERIALNO = C.SERIALNO AND C.LBLTYPE = 1 LEFT JOIN lin01 D ON IFNULL(A.PRODLINE, C.PRODLINE) = D.LINCODE WHERE A.TRXDATE BETWEEN ? AND ? AND EXISTS (SELECT SERIALNO, LOCNCODE, COUNT(*) RECORDS FROM mes01 WHERE LOCNCODE = ? AND SERIALNO = A.SERIALNO AND LOCNCODE = A.LOCNCODE GROUP BY SERIALNO, LOCNCODE HAVING RECORDS > 1) ORDER BY SERIALNO, TRXDATE",[$sdate,$edate,$location]);

        return Datatables::of($results)->make(true);
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

    function validation(Request $request) {
        $msg = "";
        $err = false;
        $data = [];
        $warn = null;
        $auto_save = false;
        $auto_remarks = "";

        $info = SerialInfo::where([
            ["SERIALNO",$request->SERIALNO],
            ["LBLTYPE",1],
        ])->first();

        if (!$info) {
            $msg = "Serial Number [" . $request->SERIALNO . "] does not exists";
        } else {
            $station = mesStation::where("STNCODE",$request->STATION)->first();
            $initloc = $station->routing()->count();
            $last_trx = $info->mes()
                            ->join("lts02","mes01.LOCNCODE","lts02.STNCODE")
                            ->where("lts02.EXEMPTROUTE",0)
                            ->selectRaw("mes01.*")
                            ->orderBy("mes01.TRXDATE","DESC")->first();
            
            $currloc = $info->CURRENTLOC == null ? "Not yet scanned" : $info->CURRENTLOC;

            if ($info->lineAssoc()->LINCAT != $request->REGISTRATION) {
                $msg = "Serial Number [" . $request->SERIALNO . "] is under " . $info->lineAssoc()->LINCAT . " Registration." ;
            } else {
                $stn = mesStation::where("STNCODE",$request->STATION)->first()->routing()->where("SRCLOC",$info->CURRENTLOC)->get();

                if ($stn->count() == 0) {
                    $stn = mesStation::where("STNCODE",$request->STATION)->first()->routing()->where("CUSTSKIP","LIKE","%".$info->CUSTOMER."%")->first();

                    if (!$stn) {
                        $err = true;
                    } else {
                        $stn2 = mesStation::where("STNCODE",$stn->SRCLOC)->first()->routing()->where("SRCLOC",$info->CURRENTLOC)->first();

                        if (!$stn2) {
                            $err = true;
                        }
                    }

                    if ($err) {
                        if ($initloc > 0 || ($initloc == 0 && $info->CURRENTLOC != null)) {
                            if ($request->STATION == $info->CURRENTLOC) {
                                $msg = "Serial Number [" . $request->SERIALNO . "] is already scanned in this location." ;
                            } else {
                                $msg = "Serial Number [" . $request->SERIALNO . "] cannot be transacted in this location. Current Location [" . $currloc . "]." ;
                            }
                        } 
                    }
                } else {
                    if ($station->UNIQUESNO == 1) {
                        $sno = $request->SERIALNO;
                        $loc = $request->STATION;

                        $data = [
                            "SERIALNO" => $sno,
                            "LOCNCODE" => $loc,
                        ];

                        $validator = Validator::make($data, [
                            'SERIALNO' => [
                                Rule::unique('web_portal.mes01')->where(function ($query) use($sno,$loc) {
                                    return $query->where('SERIALNO', $sno)
                                    ->where('LOCNCODE', $loc);
                                }),
                            ],
                        ], [
                            'SERIALNO.unique' => 'Serial Number ['.$data['SERIALNO'].'] has already passed this location. Current Location [' . $currloc . '].',
                        ]);

                        if ($validator->fails()) {
                            $err = true;
                            $msg = $validator->messages()->first();
                        }
                    }

                    if (!$err) {
                        if ($station->CLASSALLOW != '') {
                            $auto_save = true;
                            $auto_remarks = "Endorsed to " . $station->STNDESC;
                            $allowed_class = [];

                            if (strstr($station->CLASSALLOW,'|')) {
                                $allowed_class = explode('|',$station->CLASSALLOW);
                            } else {
                                array_push($allowed_class,$station->CLASSALLOW);
                            }

                            if (!in_array($info->MODCLASS,$allowed_class)) {
                                $err = true;
                            }
                        }

                        if ($err) {
                            $msg = 'Serial Number ['.$request->SERIALNO.'] current class is ['.$info->MODCLASS.']. This station only allows then following classes ['.$station->CLASSALLOW.'].';
                        } else {
                            if (count($request->TRXLAST) > 0) {
                                $last_mes = json_decode(json_encode($request->TRXLAST));
                                $last_cus = $last_mes->CUSTOMER;
                            } else {
                                $date=date_create($request->TRXDATE);
                                date_add($date,date_interval_create_from_date_string("-1 days"));
                                $date = date_format($date,"Y-m-d") . " 06:00:00";
                                
                                $last_mes = mesData::join("lbl02","mes01.SERIALNO","lbl02.SERIALNO")
                                ->where([
                                    ["mes01.LOCNCODE",$station->STNCODE],
                                    [DB::raw("IFNULL(mes01.PRODLINE,lbl02.PRODLINE)"),$request->PRODLINE],
                                    ["lbl02.LBLTYPE",1],
                                    ["TRXDATE",">=",$date],
                                ])->orderBy("TRXDATE","DESC")
                                ->select("mes01.SERIALNO","lbl02.CUSTOMER","mes01.MODCLASS","mes01.LOCNCODE")
                                ->first();
                                
                                $last_cus = ($last_mes != null ? $last_mes->serial()->where("LBLTYPE",1)->first()->CUSTOMER : "");
                            }

                            $cond = OEMCondition::where([
                                ["CUSTOMER", $last_cus],
                                ["STATION", $station->STNCODE],
                            ])->first();

                            if (!$cond) {
                                $cond = OEMCondition::where([
                                    ["CUSTOMER", $info->CUSTOMER],
                                    ["STATION", $station->STNCODE],
                                ])->first();
                            }

                            if ($cond) {
                                $warn = [
                                    "Class" => $cond->CLASS_ALLOW,
                                    "Message" => $cond->WARNING_MSG
                                ];

                                if ($cond->LASTTRX == 1) {
                                    $cserial = $last_mes->SERIALNO;
                                    $flag = ($last_mes->MODCLASS <> $cond->CLASS_ALLOW);
                                } else {
                                    $cserial = $sno;
                                    $flag = true;
                                }

                                $check = DB::connection($cond->CONN)->select("SELECT COUNT(*) AS TRX FROM ".$cond->TABLE_NAME." WHERE ".$cond->FIELD_NAME." = ?" . $cond->ADDCOND,[$cserial]);
                                $trx_count = $check[0]->TRX;
                                
                                if ($check[0]->TRX == 0 && $flag) {
                                    eval($cond->ERR_MSG);

                                    if ($e_msg <> "") {
                                        $msg = $e_msg;
                                        $err = true;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        if ($msg == "") {
            $classes = portalCustomer::where("CUSCODE",$info->CUSTOMER)->first();
            $setting = DB::connection("web_portal")->select("SELECT * FROM set01 WHERE PRODTYPE = ? AND LOCNCODE = ?",[$info->PRODTYPE,$station->STNCODE]);

            $lot_fields = DB::connection("web_portal")->select("SELECT FIELDNAME, OPTLIST, MAXREC, ISREQ FROM set02 WHERE PRODTYPE = ? AND LOCNCODE = ? AND INFOTYPE = ?",[$info->PRODTYPE,$station->STNCODE,'LOT']);
            $add_fields = DB::connection("web_portal")->select("SELECT FIELDNAME, OPTLIST, MAXREC, ISREQ FROM set02 WHERE PRODTYPE = ? AND LOCNCODE = ? AND INFOTYPE = ?",[$info->PRODTYPE,$station->STNCODE,'ADD']);

            $data = [
                "SERIALNO" => $info->SERIALNO,
                "CUSTOMER" => $info->CUSTOMER,
                "MODELNAME" => $info->PRODTYPE,
                "RECENTLOC" => $info->CURRENTLOC,
                "CURRENTCLASS" => $info->MODCLASS,
                "LAST_TRX" => $last_trx,
                "Classes" => $classes->classes(),
                "Warning" => $warn,
                "auto_save" => $auto_save,
                "auto_remarks" => $auto_remarks,
                "add_info" => count($setting) == 0 ? false : $setting[0]->ADDINFO == 1,
                "lot_info" => count($setting) == 0 ? false : $setting[0]->LOTINFO == 1,
                "add_fields" => $add_fields,
                "lot_fields" => $lot_fields,
            ];
        }

        return Response::json([
            "Messages" => [
                "Status" => $err,
                "Error" => $msg
            ],
            "Data" => $data,
        ]);
    }

    function saveTransaction(Request $request) {
        $err = false;
        $cno = $this->generateControl();
        $rec = null;
        $msg = "";

        $req = json_decode(json_encode($request->data));
        $lots = json_decode(json_encode($request->lot));
        $adds = json_decode(json_encode($request->add));

        $lot_rec = [];
        $add_rec = [];

        foreach ($lots as $lot) {
            if ($lot->INFOTYPE == "LOT") {
                // $lot_exists = DB::connection('web_portal')->table('mat01')->where('LOTNUMBER',$lot->FIELDVALUE)->count();
                $lot_exists = DB::connection('web_portal')->table('mat01')->leftJoin('ml01','mat01.LOTNUMBER','ml01.parent_lot')->where(DB::raw("IFNULL(ml01.child_lot,mat01.LOTNUMBER)"),$lot->FIELDVALUE)->count();

                if ($lot_exists == 0) {
                    $err = true;
                    $msg = $lot->FIELDNAME . " [" . $lot->FIELDVALUE . "] does not exists.";
                    break;
                }
            }

            $vals = [
                "SERIALNO" => $lot->SERIALNO,
                "LOCNCODE" => $lot->LOCNCODE,
                "INFOTYPE" => $lot->INFOTYPE,
                "FIELDNAME" => $lot->FIELDNAME,
                "FIELDVALUE" => $lot->FIELDVALUE,
            ];

            array_push($lot_rec,$vals);
        }

        foreach ($adds as $add) {
            $vals = [
                "SERIALNO" => $add->SERIALNO,
                "LOCNCODE" => $add->LOCNCODE,
                "INFOTYPE" => $add->INFOTYPE,
                "FIELDNAME" => $add->FIELDNAME,
                "FIELDVALUE" => $add->FIELDVALUE,
            ];

            array_push($add_rec,$vals);
        }

        $data = [
            "SERIALNO" => $req->SERIALNO,
            "LOCNCODE" => $req->LOCNCODE,
            "MODCLASS" => ($req->MODCLASS != null ? $req->MODCLASS : ""),
            "SNOSTAT" => $req->SNOSTAT,
            "MESCNO" => $cno,
            "REMARKS" => $req->REMARKS,
            "TRXUID" => $req->USERID,
            "TRXDATE" => DB::raw('now()'),
        ];

        if ($req->PRODLINE != "") {
            $data["PRODLINE"] = $req->PRODLINE;
        }

        $unique_sno = mesStation::where("STNCODE",$req->LOCNCODE)->first()->UNIQUESNO;

        if ($unique_sno) {
            $sno = $req->SERIALNO;
            $loc = $req->LOCNCODE;

            $validator = Validator::make($data, [
                'SERIALNO' => [
                    Rule::unique('web_portal.mes01')->where(function ($query) use($sno,$loc) {
                        return $query->where('SERIALNO', $sno)
                        ->where('LOCNCODE', $loc);
                    }),
                ],
            ], [
                'SERIALNO.unique' => 'Serial Number ['.$data['SERIALNO'].'] has already passed this location.',
            ]);

            if ($validator->fails()) {
                $err = true;
                $msg = $validator->messages()->first();
            }
        }

        if (!$err) {
            $rec = mesData::insert($data);

            if ($rec) {
                $lot_data = MESAdditional::insert($lot_rec);
                $add_data = MESAdditional::insert($add_rec);

                unset($rec);
                $rec = mesData::where([
                    ["SERIALNO",$req->SERIALNO],
                    ["LOCNCODE",$req->LOCNCODE],
                    ["TRXUID",$req->USERID],
                ])->first();
            }
        }

        return Response::json([
            "Message" => $msg,
            "Data" => $rec,
        ]);
    }
}
