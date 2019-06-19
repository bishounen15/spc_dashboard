<?php

namespace App\Http\Controllers\TRINA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TRINA\ModuleID;
use App\Models\TRINA\ModuleUpdateLog;

use Illuminate\Support\Facades\Auth;

use DB;
use Response;

class ModuleController extends Controller
{
    //
    public function __construct()
    {
        date_default_timezone_set('Asia/Manila');
    }   
    
    public function updateELGrade(Request $request) {
        $module = ModuleID::find($request->input('Module_ID'));

        $log_record = [
            "Module_ID" => $module->Module_ID,
            "field_name" => 'EL_Grade',
            "old_value" => $module->EL_Grade,
            "new_value" => $request->input('EL_Grade'),
            "user_id" => Auth::user()->id,
        ];

        $module->EL_Grade = $request->input('EL_Grade');
        $result = $module->update();

        if ($result == true) {
            $log = ModuleUpdateLog::create($log_record);
        }

        return Response::json($result);
    }

    public function ModuleUpdate() {
        return view('mes.trina.admin.modupd');
    }

    public function ListModules(Request $request) {
        $cond = '';
        $param = $request->input('param');

        if ($param == 'sno') {
            $serials = $request->input('serialno');
            $snos = explode(",",$serials . ",");
            
            $cond = "A.Module_ID IN (";

            foreach($snos as $sno) {
                $cond .= ($sno !="" ? ($cond == 'A.Module_ID IN (' ? '' : ',') . "'" . $sno . "'" : "");
            }

            $cond .= ")";
        } else {
            $start = $request->input('start');
            $end = $request->input('end');

            $cond = "A.Module_ID BETWEEN '".$start."' AND '".$end."'";
        }

        $sql = "SELECT DISTINCT A.WorkOrder_ID, A.WorkOrder_vertion, A.Module_ID, D.Product_Type, B.Module_Colour, B.Cell_Suppliers, A.Grade_of_Cell_Power, A.Cell_Power, A.Cell_Color, C.EFF, A.Module_Grade, A.EL_Grade, A.Status, E.POWER_GRADE, G.NAMEPLATE_Type, CONCAT(I.opno,' - ',I.opname) AS Operation FROM rt_wo_mid A INNER JOIN df_wo_mat B ON A.WorkOrder_ID = B.WorkOrder_ID AND A.WorkOrder_vertion = B.WorkOrder_vertion INNER JOIN df_module_cell_power C ON B.Cell_Suppliers = C.factory AND A.Grade_of_Cell_Power = C.Code AND A.Cell_Power = C.power INNER JOIN df_pid_type_mapping D ON B.Product_ID = D.Q1_ID LEFT JOIN rt_mid_flash F ON A.Module_ID = F.Module_ID LEFT JOIN df_module_powerinfo E ON CASE WHEN A.Module_Grade = A.EL_Grade AND A.Module_Grade = 'Q1' THEN D.Q1_ID ELSE D.Q2_ID END = E.Product_ID AND E.GRADE_TYPE = 'NOIMPGRADE' AND (F.PMAX >= E.LOWERPOWER AND F.PMAX < E.UPPERPOWER) LEFT JOIN v_rt_nameplate_history G ON A.Module_ID = G.Module_id INNER JOIN rt_tblwiplotstate H ON A.Module_ID = H.Module_ID INNER JOIN z_operations I ON H.OPNO = I.opno WHERE " . $cond;

        $mods = DB::connection('trina')
                            ->select($sql);

        $eff = [];
        $clr = [];

        if (count($mods) > 0) {
            $eff = DB::connection('trina')
                                ->select("SELECT CONCAT(factory,'|',EFF,'|',Code,'|',power) AS CODE, CONCAT(EFF,' - ',Code,' [',power,']') AS DESCR FROM df_module_cell_power WHERE factory = ? ORDER BY EFF, Code, power",[$mods[0]->Cell_Suppliers]);

            $clr = DB::connection('trina')
                                ->select("SELECT CONCAT(factory,'|',ModuleColor,'|',color) AS CODE, color as DESCR FROM df_module_cell_color WHERE factory = ? AND ModuleColor = ? ORDER BY color",[$mods[0]->Cell_Suppliers,$mods[0]->Module_Colour]);
        }

        $data = [];

        $data['mods'] = $mods;
        $data['eff'] = $eff;
        $data['clr'] = $clr;

        return Response::json($data);
    }

    public function UpdateModules(Request $request) {
        $update = [];

        $serials = [];
        $affected = "";
        $param = $request->input('param');

        if ($param == 'sno') {
            $serialnumbers = $request->input('serialno');
            $snos = explode(",",$serialnumbers . ",");
            
            foreach($snos as $k => $v) {
                if ($v != "") {
                    $serials[$k] = $v;
                    $affected .= ($affected == "" ? "" : ",") . $v;
                }
            }

            $modules = DB::connection('trina')
                                ->table('omes.rt_wo_mid')
                                ->whereIn('Module_ID',$serials);
        } else {
            array_push($serials, $request->input('start'));
            array_push($serials, $request->input('end'));

            $affected = $request->input('start') . " - " . $request->input('end');

            $modules = DB::connection('trina')
                                ->table('omes.rt_wo_mid')
                                ->whereBetween('Module_ID',$serials);
        }

        if ($request->input('EFF') != null) {
            $values = [];
            $values = explode("|",$request->input('EFF'));
            $update['Grade_of_Cell_Power'] = $values[2];
            $update['Cell_Power'] = $values[3];
        }

        if ($request->input('Module_Colour') != null) {
            $values = [];
            $values = explode("|",$request->input('Module_Colour'));
            $update['Cell_Color'] = $values[2];
        }

        if ($request->input('Status') != null) {
            $update['Status'] = str_replace("-","", $request->input('Status'));
        }

        if ($request->input('Module_Grade') != null) {
            $update['Module_Grade'] = str_replace("-","", $request->input('Module_Grade'));
        }

        if ($request->input('EL_Grade') != null) {
            $update['EL_Grade'] = str_replace("-","", $request->input('EL_Grade'));
        }

        if (count($update) > 0) {
            $results = $modules->update($update);

            if ($results > 0) {
                $update['affected_serials'] = $affected;
                $update['user_id'] = Auth::user()->user_id;
                $update['requestor'] = $request->input('requestor');
                $update['reason'] = $request->input('reason');

                $logs = DB::connection('trina')
                                ->table('solarph.admin_update_logs')
                                ->insert($update);
            }
        } else {
            $results = -1;
        }

        return Response::json($results);
    }
}
