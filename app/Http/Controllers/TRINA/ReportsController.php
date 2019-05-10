<?php

namespace App\Http\Controllers\TRINA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DataTables;
use DB;
use Response;

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

    function ftd($sdate = null, $edate = null, $pack = null) {
        $start = ($sdate == null ? date('Y-m-d') : date('Y-m-d',strtotime($sdate)))  . " 06:00:00";
        $end = date('Y-m-d',strtotime("+1 days",strtotime(($edate == null ? "Today" : $edate)))) . " 05:59:59";
        $cond = ($pack == null || $pack == "false" ? "" : "AND f.Module_ID IS NOT NULL");
        $sort = ($pack == null || $pack == "false" ? "a.TEST_DATETIME" : "f.Packing_Date");
        $dfield = ($pack == null || $pack == "false" ? "TEST_DATETIME" : "DATE_ADD(Packing_Date, INTERVAL CASE WHEN f.Packing_Date < '2019-04-26' THEN 15 ELSE 0 END HOUR)");
        
        $ftd = DB::connection("trina")->select("SELECT IFNULL(g.Judgement,'-') as Judgement, a.WorkOrder_ID, a.Module_ID, h.Grade_of_Cell_Power, h.Cell_Power, h.Cell_Color, i.EFF, d.Product_ID, REPLACE(e.Product_Type,'***',b.LOWERPOWER) AS Product_Type, IFNULL(f.Carton_No,'') as Carton_no, (DATE_ADD(Packing_Date, INTERVAL CASE WHEN f.Packing_Date < '2019-04-26' THEN 15 ELSE 0 END HOUR)) as Packing_Date, IFNULL(f.Container_No,'') AS Container_No, a.TEST_DATETIME, a.TITLE, b.LOWERPOWER as Grade, a.PMAX, a.FF, a.VOC, a.ISC, a.VPM, a.IPM, a.RS, a.RSH, a.EnvTemp, a.SurfTemp, IFNULL(CONCAT('ftp://192.168.128.25/',SUBSTR(a.Module_ID,1,10),'/',MAX(c.FILEPATH)),'') AS FILEPATH FROM omes.rt_mid_flash a inner join omes.df_wo_mat d on a.WorkOrder_ID = d.WorkOrder_ID inner join omes.df_module_powersetting b on a.WorkOrder_ID = b.WorkOrder_id and d.Product_ID = b.Product_ID inner join omes.df_pid_type_mapping e on d.Product_ID = e.Q1_ID and (a.PMAX >= b.LOWERPOWER and a.PMAX < b.UPPERPOWER) LEFT JOIN omes.rt_modulepelresults c on a.Module_ID = c.MODULEID left join omes.rt_mid_packing f on a.Module_ID = f.Module_ID and f.State = 'Packed' left join solarph.oba g on a.Module_ID = g.Module_ID and f.Carton_No = g.Carton_no inner join omes.rt_wo_mid h on a.Module_ID = h.Module_ID inner join omes.df_module_cell_power i on d.Cell_Suppliers = i.factory and h.Grade_of_Cell_Power = i.Code and h.Cell_Power = i.power where a.Module_ID like 'S98%' AND ".$dfield." BETWEEN ? AND ? ".$cond." GROUP BY g.Judgement, a.WorkOrder_ID, a.Module_ID, h.Grade_of_Cell_Power, h.Cell_Power, h.Cell_Color, i.EFF, d.Product_ID, e.Product_Type, f.Carton_No, f.Packing_Date, f.Container_No, a.TEST_DATETIME, a.TITLE, b.LOWERPOWER, a.PMAX, a.FF, a.VOC, a.ISC, a.VPM, a.IPM, a.RS, a.RSH, a.EnvTemp, a.SurfTemp ORDER BY ".$sort,[$start,$end]);

        return Datatables::of($ftd)->make(true);
    }

    function lotReport() {
        return view('mes.trina.lot');
    }

    function LotNumbers() {
        $lot = DB::connection("trina")->select("SELECT A.Module, A.Material, A.LotNumber, A.total, D.max_total FROM omes.v_lotnumbers A INNER JOIN omes.z_material_setup D ON A.Material = D.Material INNER JOIN (SELECT * FROM omes.rt_mid_frameup_hist ORDER BY Process_time DESC LIMIT 1) B ON A.LotNumber = B.frame_lot OR A.LotNumber = B.ShortFrame_lot union all SELECT A.Module, A.Material, A.LotNumber, A.total, D.max_total FROM omes.v_lotnumbers A INNER JOIN omes.z_material_setup D ON A.Material = D.Material INNER JOIN (SELECT * FROM omes.rt_mid_layup_hist ORDER BY Process_time DESC LIMIT 1) C ON A.LotNumber = C.Backsheet_lot OR A.LotNumber = C.EVA_lot OR A.LotNumber = C.OrdinaryEVA_lot OR A.LotNumber = C.Glass_lot");

        return Datatables::of($lot)->make(true);
    }

    function moduleInquiry() {
        return view('mes.trina.inquire');
    }

    function Inquire(Request $request) {
        $ModuleID = $request->input("Module_ID");
        $info = DB::connection("trina")->select("SELECT A.Module_ID, B.OrderID, A.WorkOrder_ID, A.WorkOrder_vertion, B.Product_ID, C.Product_Type, A.Module_Grade, A.EL_Grade, A.Status, B.Cell_MID, B.Cell_Suppliers, B.Cell_Size, B.Cell_Thickness, B.BackSheet_MID, B.BackSheet_Dec, B.BackSheet_Suppliers, B.BackSheet_Thickness, B.EVA_MID, B.EVA_Suppliers, B.OrdinaryEVA_MID, B.OrdinaryEVA_Suppliers, B.Glass_MID, B.Glass_Suppliers, B.Frame_MID, B.Frame_Suppliers, B.ShortFrame_MID, B.ShortFrame_Suppliers, B.IsBonded, B.bar_type, B.CTCFac, B.CTCStd, B.StringFac, B.StringStd, CONCAT(N.OPNO, ' - ',Q.opname) as 'Operation', DATE_ADD(D.printtime,INTERVAL CASE WHEN D.printtime < '2019-04-26' THEN 15 ELSE 0 END HOUR) AS 'LabelDate', DATE_ADD(E.CreateTime,INTERVAL CASE WHEN E.CreateTime < '2019-04-26' THEN 15 ELSE 0 END HOUR) AS 'StringDate', E.Carton_No AS 'CellLot', DATE_ADD(F.Process_time,INTERVAL CASE WHEN F.Process_time < '2019-04-26' THEN 15 ELSE 0 END HOUR) AS 'LayupDate', F.Backsheet_lot, F.EVA_lot, F.OrdinaryEVA_lot, F.Glass_lot, DATE_ADD(G.Process_time,INTERVAL CASE WHEN G.Process_time < '2019-04-26' THEN 15 ELSE 0 END HOUR) AS 'FrameUpDate', G.frame_lot, G.ShortFrame_lot, G.JBOX_lot, DATE_ADD(H.Process_time,INTERVAL CASE WHEN H.Process_time < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'CleaningHoldDate', O.TEST_DATETIME as 'Testdate', O.PMAX, O.VOC, O.ISC, O.VPM, O.IPM, O.RS, O.RSH, O.FF, O.EnvTemp, O.SurfTemp, P.ELTIME, CONCAT('ftp://192.168.128.25/',SUBSTR(A.Module_ID,1,10),'/',P.FILEPATH) as ELPath, DATE_ADD(I.Process_time,INTERVAL CASE WHEN I.Process_time < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'QCPassDate', DATE_ADD(J.Printtime,INTERVAL CASE WHEN J.Printtime < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'NPOnlineDate', J.Product_Type as Product, J.Qlevel, DATE_ADD(K.Printtime,INTERVAL CASE WHEN K.Printtime < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'LastReprintDate', K.Prints as 'TotalReprints', L.Carton_No, DATE_ADD(L.Packing_Date,INTERVAL CASE WHEN L.Packing_Date < '2019-04-26' THEN 15 ELSE 0 END HOUR) as Packing_Date, L.State as 'PackingState', M.Container_no, DATE_ADD(M.buildcabtime,INTERVAL CASE WHEN M.buildcabtime < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'ContainerDate' FROM omes.rt_wo_mid A INNER JOIN omes.df_wo_mat B ON A.WorkOrder_ID = B.WorkOrder_ID INNER JOIN omes.df_pid_type_mapping C ON B.Product_ID = C.Q1_ID inner join omes.rt_tblwiplotstate N on A.Module_ID = N.Module_id inner join omes.z_operations Q on N.OPNO = Q.opno LEFT JOIN (select Module_ID, max(printtime) as printtime from omes.rt_module_printlabellog where siteid = 'CreateLabel' group by Module_id) D on A.Module_ID = D.Module_id left join omes.rt_mid_cellsizing E on A.Module_ID = E.Module_id left join omes.rt_mid_layup_hist F on A.Module_ID = F.Module_id left join omes.rt_mid_frameup_hist G on A.Module_ID = G.Module_id left join (select Module_id, MAX(Create_Date) AS Process_time from omes.rt_tblwipcont_error where SiteID = 'CYHJ' group by Module_id) H on A.Module_ID = H.Module_id left join (select Module_id, MAX(Create_Date) AS Process_time from omes.rt_tblwipcont_error where EqpID is null group by Module_id) I on A.Module_ID = I.Module_id left join (select Module_id, replace(Product_Type,'***',Grade) as Product_Type, Qlevel, Printtime from omes.rt_nameplate_history where SiteID = 'OnLine') J on A.Module_ID = J.Module_ID left join (select Module_id, max(Printtime) as Printtime, count(*) as Prints from omes.rt_nameplate_history where SiteID = 'Reprint' group by Module_id) K on A.Module_ID = K.Module_ID left join omes.rt_mid_packing L on A.Module_ID = L.Module_ID left join omes.rt_mid_buildcontainer M on L.Carton_No = M.Carton_no left join omes.rt_mid_flash O on A.Module_ID = O.Module_ID left join omes.rt_module_elresult P on A.Module_ID = P.MODULEID WHERE A.Module_ID = ? AND A.Create_Date > '2019-04-15' ORDER BY Carton_no, Packing_Date",[$ModuleID]);

        return Response::json($info);
    }

    function containerReport() {
        return view('mes.trina.container');
    }

    function containerInfo($sdate = null, $edate = null) {
        $start = ($sdate == null ? date('Y-m-d') : date('Y-m-d',strtotime($sdate)))  . " 06:00:00";
        $end = date('Y-m-d',strtotime("+1 days",strtotime(($edate == null ? "Today" : $edate)))) . " 05:59:59";
        
        $container = DB::connection("trina")->select("SELECT '' as `Contract no`, a.Container_No as `Batch No`, a.Carton_No as 'Carton No', a.WorkOrder_ID as 'Workorder ID', a.Module_ID as 'Module ID', a.Product_ID as 'Product ID', a.Product_Type as 'Product Type', '' as 'Purchase Order', '' as 'Country Of Original', b.Cell_Suppliers as 'Cell Suppliers', '' as 'CONTAINER No', '' as 'SEAL', '' as 'BOL', '' as 'Ship destination', b.Layout_QTY_of_Cell as 'Cells Per Panel', DATE_ADD(c.Create_Date,INTERVAL CASE WHEN c.Create_Date < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'Production Date', b.Cell_MID as 'cell No', a.Module_Grade as 'MODULE GRADE' FROM omes.rt_mid_packing a inner join omes.df_wo_mat b on a.WorkOrder_ID = b.WorkOrder_ID inner join omes.rt_wo_mid c on a.Module_ID = c.Module_ID where a.Module_ID like 'S98%' AND a.State = 'Packed' AND DATE_ADD(a.Packing_Date,INTERVAL CASE WHEN a.Packing_Date < '2019-04-26' THEN 15 ELSE 0 END HOUR) BETWEEN ? AND ? ORDER BY a.Carton_No, a.Packing_Date",[$start,$end]);

        return Datatables::of($container)->make(true);
    }
}
