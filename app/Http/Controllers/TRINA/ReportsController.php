<?php

namespace App\Http\Controllers\TRINA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DataTables;
use DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Manila');
    }   

    //
    function ftdReport() {
        return view('mes.trina.ftd');
    }

    function ftd($sdate = null, $edate = null) {
        $start = ($sdate == null ? date('Y-m-d') : date('Y-m-d',strtotime($sdate)))  . " 06:00:00";
        $end = date('Y-m-d',strtotime("+1 days",strtotime(($edate == null ? "Today" : $edate)))) . " 05:59:59";

        $ftd = DB::connection("trina")->select("SELECT a.WorkOrder_ID, a.Module_ID, a.TEST_DATETIME, a.TITLE, b.LOWERPOWER as Grade, a.PMAX, a.FF, a.VOC, a.ISC, a.VPM, a.IPM, a.RS, a.RSH, a.EnvTemp, a.SurfTemp, IFNULL(CONCAT('ftp://192.168.128.25/',SUBSTR(a.Module_ID,1,10),'/',MAX(c.FILEPATH)),'') AS FILEPATH FROM omes.rt_mid_flash a inner join omes.df_module_powersetting b on a.WorkOrder_ID = b.WorkOrder_id and (a.PMAX >= b.LOWERPOWER and a.PMAX < b.UPPERPOWER) LEFT JOIN omes.rt_modulepelresults c on a.Module_ID = c.MODULEID where Module_ID like 'S98%' AND TEST_DATETIME BETWEEN ? AND ? GROUP BY a.WorkOrder_ID, a.Module_ID, a.TEST_DATETIME, a.TITLE, b.LOWERPOWER, a.PMAX, a.FF, a.VOC, a.ISC, a.VPM, a.IPM, a.RS, a.RSH, a.EnvTemp, a.SurfTemp",[$start,$end]);

        return Datatables::of($ftd)->make(true);
    }

    function lotReport() {
        return view('mes.trina.lot');
    }

    function LotNumbers() {
        $lot = DB::connection("trina")->select("SELECT A.Module, A.Material, A.LotNumber, A.total, D.max_total FROM omes.v_lotnumbers A INNER JOIN omes.z_material_setup D ON A.Material = D.Material INNER JOIN (SELECT * FROM omes.rt_mid_frameup_hist ORDER BY Process_time DESC LIMIT 1) B ON A.LotNumber = B.frame_lot OR A.LotNumber = B.ShortFrame_lot union all SELECT A.Module, A.Material, A.LotNumber, A.total, D.max_total FROM omes.v_lotnumbers A INNER JOIN omes.z_material_setup D ON A.Material = D.Material INNER JOIN (SELECT * FROM omes.rt_mid_layup_hist ORDER BY Process_time DESC LIMIT 1) C ON A.LotNumber = C.Backsheet_lot OR A.LotNumber = C.EVA_lot OR A.LotNumber = C.OrdinaryEVA_lot OR A.LotNumber = C.Glass_lot");

        return Datatables::of($lot)->make(true);
    }
}
