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
        $data = [];

        $data['product_types'] = DB::connection('trina')->select("SELECT DISTINCT Product_Type FROM df_pid_type_mapping A WHERE EXISTS (SELECT Product_ID FROM df_wo_mat WHERE WorkOrder_ID LIKE 'S%' AND Product_ID = A.Q1_ID) ORDER BY Product_Type");

        $data['work_orders'] = DB::connection('trina')->select("SELECT A.WorkOrder_ID, B.Product_Type FROM df_wo_mat A INNER JOIN df_pid_type_mapping B ON A.Product_ID = B.Q1_ID WHERE A.WorkOrder_ID LIKE 'S%' ORDER BY A.WorkOrder_ID");

        return view('mes.trina.ftd', $data);
    }

    function ftd(Request $request, $sdate = null, $edate = null, $pack = null, $shipped = null) {
        $start = ($sdate == null ? date('Y-m-d') : date('Y-m-d',strtotime($sdate)))  . " 06:00:00";
        $end = date('Y-m-d',strtotime("+1 days",strtotime(($edate == null ? "Today" : $edate)))) . " 05:59:59";
        $cond = ($request->form_PackStatus == "All" ? "" : "AND K.Module_ID IS".($request->form_PackStatus == "Packed" ? " NOT" : "")." NULL");
        $sort = ($request->form_PackStatus == "All" || $request->form_PackStatus == "Not Packed" ? "F.TEST_DATETIME" : "K.Packing_Date");
        $dfield = ($request->form_PackStatus != "Packed" ? "TEST_DATETIME" : "DATE_ADD(Packing_Date, INTERVAL CASE WHEN K.Packing_Date < '2019-04-26' THEN 15 ELSE 0 END HOUR)");
        $scond = ($request->form_ShipStatus == "All" ? "" : " AND".($request->form_ShipStatus == "Not Shipped" ? " NOT" : "")." EXISTS (SELECT container_no FROM solarph.shipped_container WHERE container_no = K.Container_No)");
        
        $filtercond =  $request->form_ModuleGrade == "All" ? "" : " AND CASE WHEN A.Module_Grade = A.EL_Grade AND A.Module_Grade = 'Q1' THEN 'Q1' ELSE 'Q2' END = '" . $request->form_ModuleGrade . "'";

        if ($request->form_Product_Type != null) {
            $ptype = "";
            if (strpos($request->form_Product_Type, '|') !== false) {
                $ptypes = [];
                $ptypes = explode("|",$request->form_Product_Type);

                foreach($ptypes as $pt) {
                    $ptype .= ($ptype == "" ? "" : ",") . "'" . $pt . "'";
                }
            } else {
                $ptype = "'" . $request->form_Product_Type . "'";
            }

            $filtercond .= " AND D.Product_Type IN (".$ptype.")";
        }

        if ($request->form_WorkOrder_ID != null) {
            $workorders = "";
            if (strpos($request->form_WorkOrder_ID, '|') !== false) {
                $wos = [];
                $wos = explode("|",$request->form_WorkOrder_ID);

                foreach($wos as $wo) {
                    $workorders .= ($workorders == "" ? "" : ",") . "'" . $wo . "'";
                }
            } else {
                $workorders = "'" . $request->form_WorkOrder_ID . "'";
            }

            $filtercond .= " AND A.WorkOrder_ID IN (".$workorders.")";
        }

        $ftd = DB::connection("trina")->select("SELECT IFNULL(M.Judgement,'-') as Judgement, A.WorkOrder_ID, A.Module_ID, A.Module_Grade, A.EL_Grade, CASE WHEN A.Module_Grade = A.EL_Grade AND A.Module_Grade = 'Q1' THEN D.Q1_ID ELSE D.Q2_ID END AS Product_ID, D.Product_Type, A.Grade_of_Cell_Power, A.Cell_Power, A.Cell_Color, C.EFF, K.Carton_no, K.Packing_Date, K.Container_No, F.TEST_DATETIME, F.TITLE, IFNULL(J.POWER_GRADE,E.POWER_GRADE) AS Grade, F.PMAX, F.FF, F.VOC, F.ISC, F.VPM, F.IPM, F.RS, F.RSH, F.EnvTemp, F.SurfTemp, IFNULL(G.NAMEPLATE_Type,'') AS NAMEPLATE_Type, IFNULL(CONCAT('ftp://192.168.128.25/',SUBSTR(a.Module_ID,1,10),'/',L.FILEPATH),'') AS FILEPATH FROM rt_wo_mid A INNER JOIN df_wo_mat B ON A.WorkOrder_ID = B.WorkOrder_ID AND A.WorkOrder_vertion = B.WorkOrder_vertion INNER JOIN df_module_cell_power C ON B.Cell_Suppliers = C.factory AND A.Grade_of_Cell_Power = C.Code AND A.Cell_Power = C.power INNER JOIN df_pid_type_mapping D ON B.Product_ID = D.Q1_ID INNER JOIN rt_mid_flash F ON A.Module_ID = F.Module_ID LEFT JOIN df_module_powerinfo E ON CASE WHEN A.Module_Grade = A.EL_Grade AND A.Module_Grade = 'Q1' THEN D.Q1_ID ELSE D.Q2_ID END = E.Product_ID AND E.GRADE_TYPE = 'NOIMPGRADE' AND (F.PMAX >= E.LOWERPOWER AND F.PMAX < E.UPPERPOWER) AND E.WorkOrder_id = '*' LEFT JOIN df_module_powerinfo J ON CASE WHEN A.Module_Grade = A.EL_Grade AND A.Module_Grade = 'Q1' THEN D.Q1_ID ELSE D.Q2_ID END = J.Product_ID AND J.GRADE_TYPE = 'NOIMPGRADE' AND (F.PMAX >= J.LOWERPOWER AND F.PMAX < J.UPPERPOWER) AND A.WorkOrder_id = J.WorkOrder_id LEFT JOIN v_rt_nameplate_history G ON A.Module_ID = G.Module_id LEFT JOIN rt_mid_packing K ON A.Module_ID = K.Module_ID AND K.State IN ('Packed','Wait') LEFT JOIN rt_module_elresult L ON A.Module_ID = L.MODULEID LEFT JOIN solarph.oba M ON A.Module_ID = M.Module_ID AND K.Carton_No = M.Carton_no WHERE A.Module_ID like 'S98%' AND ".$dfield." BETWEEN ? AND ? ".$cond.$scond.$filtercond." ORDER BY ".$sort,[$start,$end]);

        return Datatables::of($ftd)->make(true);
    }

    function modInfo() {
        $data = [];

        $data['product_types'] = DB::connection('trina')->select("SELECT DISTINCT Product_Type FROM df_pid_type_mapping A WHERE EXISTS (SELECT Product_ID FROM df_wo_mat WHERE WorkOrder_ID LIKE 'S%' AND Product_ID = A.Q1_ID) ORDER BY Product_Type");

        $data['work_orders'] = DB::connection('trina')->select("SELECT A.WorkOrder_ID, B.Product_Type FROM df_wo_mat A INNER JOIN df_pid_type_mapping B ON A.Product_ID = B.Q1_ID WHERE A.WorkOrder_ID LIKE 'S%' ORDER BY A.WorkOrder_ID");

        return view('mes.trina.modinfo', $data);
    }

    function moduleInfo(Request $request, $sdate = null, $edate = null) {
        $start = ($sdate == null ? date('Y-m-d') : date('Y-m-d',strtotime($sdate)))  . " 06:00:00";
        $end = date('Y-m-d',strtotime("+1 days",strtotime(($edate == null ? "Today" : $edate)))) . " 05:59:59";
        
        $cond = ($request->form_PackStatus == "All" ? "" : "AND L.Module_ID IS".($request->form_PackStatus == "Packed" ? " NOT" : "")." NULL");

        $scond = ($request->form_ShipStatus == "All" ? "" : " AND".($request->form_ShipStatus == "Not Shipped" ? " NOT" : "")." EXISTS (SELECT container_no FROM solarph.shipped_container WHERE container_no = M.Container_No)");

        $filtercond =  $request->form_ModuleGrade == "All" ? "" : " AND CASE WHEN A.Module_Grade = A.EL_Grade AND A.Module_Grade = 'Q1' THEN 'Q1' ELSE 'Q2' END = '" . $request->form_ModuleGrade . "'";

        if ($request->form_Product_Type != null) {
            $ptype = "";
            if (strpos($request->form_Product_Type, '|') !== false) {
                $ptypes = [];
                $ptypes = explode("|",$request->form_Product_Type);

                foreach($ptypes as $pt) {
                    $ptype .= ($ptype == "" ? "" : ",") . "'" . $pt . "'";
                }
            } else {
                $ptype = "'" . $request->form_Product_Type . "'";
            }

            $filtercond .= " AND C.Product_Type IN (".$ptype.")";
        }

        if ($request->form_WorkOrder_ID != null) {
            $workorders = "";
            if (strpos($request->form_WorkOrder_ID, '|') !== false) {
                $wos = [];
                $wos = explode("|",$request->form_WorkOrder_ID);

                foreach($wos as $wo) {
                    $workorders .= ($workorders == "" ? "" : ",") . "'" . $wo . "'";
                }
            } else {
                $workorders = "'" . $request->form_WorkOrder_ID . "'";
            }

            $filtercond .= " AND A.WorkOrder_ID IN (".$workorders.")";
        }

        $modInfo = DB::connection("trina")->select("SELECT A.Module_ID, B.OrderID, A.WorkOrder_ID, A.WorkOrder_vertion, B.Product_ID, C.Product_Type, A.Module_Grade, A.EL_Grade, A.Status, L.Carton_No, O.Title, O.TEST_DATETIME, DATE_ADD(L.Packing_Date,INTERVAL CASE WHEN L.Packing_Date < '2019-04-26' THEN 15 ELSE 0 END HOUR) as Packing_Date, L.State as 'PackingState', M.Container_no, DATE_ADD(M.buildcabtime,INTERVAL CASE WHEN M.buildcabtime < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'ContainerDate' FROM omes.rt_wo_mid A INNER JOIN omes.df_wo_mat B ON A.WorkOrder_ID = B.WorkOrder_ID INNER JOIN omes.df_pid_type_mapping C ON B.Product_ID = C.Q1_ID left join omes.rt_mid_packing L on A.Module_ID = L.Module_ID AND L.State IN ('Packed','Wait') left join omes.rt_mid_buildcontainer M on L.Carton_No = M.Carton_no left join omes.rt_mid_flash O on A.Module_ID = O.Module_ID left join omes.rt_module_elresult P on A.Module_ID = P.MODULEID WHERE A.Module_ID LIKE 'S98%' AND A.WorkOrder_ID LIKE 'S19%' AND DATE_ADD(A.Create_Date,INTERVAL CASE WHEN A.Create_Date < '2019-04-26' THEN 15 ELSE 0 END HOUR) BETWEEN ? AND ? ".$cond.$scond.$filtercond." ORDER BY A.WorkOrder_ID, A.Module_ID",[$start,$end]);

        return Datatables::of($modInfo)->make(true);
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
        $info = DB::connection("trina")->select("SELECT A.Module_ID, B.OrderID, A.WorkOrder_ID, A.WorkOrder_vertion, B.Product_ID, C.Product_Type, A.Module_Grade, A.EL_Grade, A.Status, B.Cell_MID, B.Cell_Suppliers, B.Cell_Size, B.Cell_Thickness, B.BackSheet_MID, B.BackSheet_Dec, B.BackSheet_Suppliers, B.BackSheet_Thickness, B.EVA_MID, B.EVA_Suppliers, B.OrdinaryEVA_MID, B.OrdinaryEVA_Suppliers, B.Glass_MID, B.Glass_Suppliers, B.Frame_MID, B.Frame_Suppliers, B.ShortFrame_MID, B.ShortFrame_Suppliers, B.IsBonded, B.bar_type, B.CTCFac, B.CTCStd, B.StringFac, B.StringStd, CONCAT(N.OPNO, ' - ',Q.opname) as 'Operation', DATE_ADD(D.printtime,INTERVAL CASE WHEN D.printtime < '2019-04-26' THEN 15 ELSE 0 END HOUR) AS 'LabelDate', DATE_ADD(E.CreateTime,INTERVAL CASE WHEN E.CreateTime < '2019-04-26' THEN 15 ELSE 0 END HOUR) AS 'StringDate', E.Carton_No AS 'CellLot', DATE_ADD(F.Process_time,INTERVAL CASE WHEN F.Process_time < '2019-04-26' THEN 15 ELSE 0 END HOUR) AS 'LayupDate', F.Backsheet_lot, F.EVA_lot, F.OrdinaryEVA_lot, F.Glass_lot, DATE_ADD(G.Process_time,INTERVAL CASE WHEN G.Process_time < '2019-04-26' THEN 15 ELSE 0 END HOUR) AS 'FrameUpDate', G.frame_lot, G.ShortFrame_lot, G.JBOX_lot, DATE_ADD(H.Process_time,INTERVAL CASE WHEN H.Process_time < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'CleaningHoldDate', O.TEST_DATETIME as 'Testdate', O.PMAX, O.VOC, O.ISC, O.VPM, O.IPM, O.RS, O.RSH, O.FF, O.EnvTemp, O.SurfTemp, P.ELTIME, CONCAT('ftp://192.168.128.25/',SUBSTR(A.Module_ID,1,10),'/',P.FILEPATH) as ELPath, DATE_ADD(I.Process_time,INTERVAL CASE WHEN I.Process_time < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'QCPassDate', DATE_ADD(J.Printtime,INTERVAL CASE WHEN J.Printtime < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'NPOnlineDate', J.Product_Type as Product, J.Qlevel, DATE_ADD(K.Printtime,INTERVAL CASE WHEN K.Printtime < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'LastReprintDate', K.Prints as 'TotalReprints', L.Carton_No, DATE_ADD(L.Packing_Date,INTERVAL CASE WHEN L.Packing_Date < '2019-04-26' THEN 15 ELSE 0 END HOUR) as Packing_Date, L.State as 'PackingState', M.Container_no, DATE_ADD(M.buildcabtime,INTERVAL CASE WHEN M.buildcabtime < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'ContainerDate' FROM omes.rt_wo_mid A INNER JOIN omes.df_wo_mat B ON A.WorkOrder_ID = B.WorkOrder_ID INNER JOIN omes.df_pid_type_mapping C ON B.Product_ID = C.Q1_ID inner join omes.rt_tblwiplotstate N on A.Module_ID = N.Module_id inner join omes.z_operations Q on N.OPNO = Q.opno LEFT JOIN (select Module_ID, max(printtime) as printtime from omes.rt_module_printlabellog where siteid = 'CreateLabel' group by Module_id) D on A.Module_ID = D.Module_id left join omes.rt_mid_cellsizing E on A.Module_ID = E.Module_id left join omes.rt_mid_layup_hist F on A.Module_ID = F.Module_id left join omes.rt_mid_frameup_hist G on A.Module_ID = G.Module_id left join (select Module_id, MAX(Create_Date) AS Process_time from omes.rt_tblwipcont_error where SiteID = 'CYHJ' group by Module_id) H on A.Module_ID = H.Module_id left join (select Module_id, MAX(Create_Date) AS Process_time from omes.rt_tblwipcont_error where EqpID is null group by Module_id) I on A.Module_ID = I.Module_id left join (select Module_id, NAMEPLATE_Type as Product_Type, Qlevel, Printtime from omes.v_rt_nameplate_history where SiteID = 'OnLine') J on A.Module_ID = J.Module_ID left join (select Module_id, max(Printtime) as Printtime, count(*) as Prints from omes.rt_nameplate_history where SiteID = 'Reprint' group by Module_id) K on A.Module_ID = K.Module_ID left join omes.rt_mid_packing L on A.Module_ID = L.Module_ID and L.State IN ('Packed','Wait') left join omes.rt_mid_buildcontainer M on L.Carton_No = M.Carton_no left join omes.rt_mid_flash O on A.Module_ID = O.Module_ID left join omes.rt_module_elresult P on A.Module_ID = P.MODULEID WHERE A.Module_ID = ? AND A.Create_Date > '2019-04-15' ORDER BY Carton_no, Packing_Date",[$ModuleID]);

        return Response::json($info);
    }

    function containerReport() {
        $data = [];

        $data['product_types'] = DB::connection('trina')->select("SELECT DISTINCT Product_Type FROM df_pid_type_mapping A WHERE EXISTS (SELECT Product_ID FROM df_wo_mat WHERE WorkOrder_ID LIKE 'S%' AND Product_ID = A.Q1_ID) ORDER BY Product_Type");

        $data['work_orders'] = DB::connection('trina')->select("SELECT A.WorkOrder_ID, B.Product_Type FROM df_wo_mat A INNER JOIN df_pid_type_mapping B ON A.Product_ID = B.Q1_ID WHERE A.WorkOrder_ID LIKE 'S%' ORDER BY A.WorkOrder_ID");

        return view('mes.trina.container', $data);
    }

    function containerInfo(Request $request, $sdate = null, $edate = null, $shipped = null) {
        $start = ($sdate == null ? date('Y-m-d') : date('Y-m-d',strtotime($sdate)))  . " 06:00:00";
        $end = date('Y-m-d',strtotime("+1 days",strtotime(($edate == null ? "Today" : $edate)))) . " 05:59:59";
        $cond = ($request->form_ShipStatus == "All" ? "" : " AND".($request->form_ShipStatus == "Not Shipped" ? " NOT" : "")." EXISTS (SELECT container_no FROM solarph.shipped_container WHERE container_no = a.Container_No)");

        $filtercond =  $request->form_ModuleGrade == "All" ? "" : " AND CASE WHEN c.Module_Grade = c.EL_Grade AND c.Module_Grade = 'Q1' THEN 'Q1' ELSE 'Q2' END = '" . $request->form_ModuleGrade . "'";

        if ($request->form_Product_Type != null) {
            $ptype = "";
            if (strpos($request->form_Product_Type, '|') !== false) {
                $ptypes = [];
                $ptypes = explode("|",$request->form_Product_Type);

                foreach($ptypes as $pt) {
                    $ptype .= ($ptype == "" ? "" : ",") . "'" . $pt . "'";
                }
            } else {
                $ptype = "'" . $request->form_Product_Type . "'";
            }

            $filtercond .= " AND d.Product_Type IN (".$ptype.")";
        }

        if ($request->form_WorkOrder_ID != null) {
            $workorders = "";
            if (strpos($request->form_WorkOrder_ID, '|') !== false) {
                $wos = [];
                $wos = explode("|",$request->form_WorkOrder_ID);

                foreach($wos as $wo) {
                    $workorders .= ($workorders == "" ? "" : ",") . "'" . $wo . "'";
                }
            } else {
                $workorders = "'" . $request->form_WorkOrder_ID . "'";
            }

            $filtercond .= " AND a.WorkOrder_ID IN (".$workorders.")";
        }

        if ($request->form_Container_no != null) {
            $containerno = "";
            if (strpos($request->form_Container_no, ',') !== false) {
                $cnos = [];
                $cnos = explode(",",$request->form_Container_no);

                foreach($cnos as $cno) {
                    $containerno .= ($containerno == "" ? "" : ",") . "'" . $cno . "'";
                }
            } else {
                $containerno = "'" . $request->form_Container_no . "'";
            }

            $filtercond .= " AND a.Container_no IN (".$containerno.")";
        }

        $container = DB::connection("trina")->select("SELECT '' as `Contract no`, a.Container_No as `Batch No`, a.Carton_No as 'Carton No', a.WorkOrder_ID as 'Workorder ID', a.Module_ID as 'Module ID', a.Product_ID as 'Product ID', a.Product_Type as 'Product Type', f.po_number as 'Purchase Order', '' as 'Country Of Original', b.Cell_Suppliers as 'Cell Suppliers', '' as 'CONTAINER No', '' as 'SEAL', '' as 'BOL', '' as 'Ship destination', b.Layout_QTY_of_Cell as 'Cells Per Panel', DATE_ADD(c.Create_Date,INTERVAL CASE WHEN c.Create_Date < '2019-04-26' THEN 15 ELSE 0 END HOUR) as 'Production Date', b.Cell_MID as 'cell No', a.Module_Grade as 'MODULE GRADE' FROM omes.rt_mid_packing a inner join omes.df_wo_mat b on a.WorkOrder_ID = b.WorkOrder_ID inner join omes.rt_wo_mid c on a.Module_ID = c.Module_ID INNER JOIN omes.df_pid_type_mapping d ON b.Product_ID = d.Q1_ID LEFT JOIN omes.rt_mid_cellsizing e ON a.Module_ID = e.Module_ID LEFT JOIN solarph.po_data f ON e.CellBarCode = f.cell_lot where a.Module_ID like 'S98%' AND a.State = 'Packed' AND DATE_ADD(a.Packing_Date,INTERVAL CASE WHEN a.Packing_Date < '2019-04-26' THEN 15 ELSE 0 END HOUR) BETWEEN ? AND ?" . $cond . $filtercond . " ORDER BY a.Carton_No, a.Packing_Date",[$start,$end]);

        return Datatables::of($container)->make(true);
    }
}
