<?php

namespace App\Http\Controllers\TRINA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DataTables;
use DB;
use Response;

class FlashTestController extends Controller
{
    //
    public function __construct()
    {
        date_default_timezone_set('Asia/Manila');
    }

    public function index()
    {
        //
        return view('mes.trina.flashtest');
    }

    public function load($ModuleID) {
        $info = DB::connection("trina")->select("SELECT A.Module_ID, A.WorkOrder_ID, B.Product_ID, D.Product_Type, B.Module_Colour, A.Grade_of_Cell_Power, A.Cell_Power, A.Cell_Color, C.EFF FROM rt_wo_mid A INNER JOIN df_wo_mat B ON A.WorkOrder_ID = B.WorkOrder_ID AND A.WorkOrder_vertion = B.WorkOrder_vertion INNER JOIN df_module_cell_power C ON A.Grade_of_Cell_Power = C.Code AND A.Cell_Power = C.power AND B.Cell_Suppliers = C.factory INNER JOIN df_pid_type_mapping D ON B.Product_ID = D.Q1_ID WHERE Module_ID = ?",[$ModuleID]);

        return Response::json($info);
    }

    public function testResults($ModuleID) {
        $eflash = \App\Models\TRINA\EqpFlash::selectRaw("omes.rt_eqp_flash.Title,omes.rt_eqp_flash.WorkOrder_ID,omes.rt_eqp_flash.Module_ID,omes.rt_eqp_flash.TEST_DATETIME,omes.rt_eqp_flash.PMAX,omes.rt_eqp_flash.FF,omes.rt_eqp_flash.VOC,omes.rt_eqp_flash.ISC,omes.rt_eqp_flash.VPM,omes.rt_eqp_flash.IPM,omes.rt_eqp_flash.RS,omes.rt_eqp_flash.RSH,omes.rt_eqp_flash.EnvTemp,omes.rt_eqp_flash.SurfTemp,omes.rt_eqp_flash.Remark,CASE WHEN omes.rt_mid_flash.WorkOrder_ID IS NOT NULL THEN true ELSE false END AS IsDefault")
                                            ->leftJoin("omes.rt_mid_flash",[
                                                ["omes.rt_eqp_flash.WorkOrder_ID","omes.rt_mid_flash.WorkOrder_ID"],
                                                ["omes.rt_eqp_flash.Module_ID","omes.rt_mid_flash.Module_ID"],
                                                ["omes.rt_eqp_flash.TEST_DATETIME","omes.rt_mid_flash.TEST_DATETIME"],
                                            ])
                                            ->where("omes.rt_eqp_flash.Module_ID",$ModuleID)
                                            ->orderBy("omes.rt_eqp_flash.TEST_DATETIME","DESC")
                                            ->get();

        return Datatables::of($eflash)->make(true);
    }

    public function resetPower($WorkOrder_ID, $Module_ID, $TEST_DATETIME) {
        $eflash = \App\Models\TRINA\EqpFlash::select("Title","WorkOrder_ID","Module_ID","TEST_DATETIME","PMAX","FF","VOC","ISC","VPM","IPM","RS","RSH","EnvTemp","SurfTemp","Remark")->where([
            ["WorkOrder_ID",$WorkOrder_ID],
            ["Module_ID",$Module_ID],
            ["TEST_DATETIME",$TEST_DATETIME],
        ])->first();

        $data = [];

        $data['Title'] = $eflash->Title;
        $data['WorkOrder_ID'] = $eflash->WorkOrder_ID;
        $data['Module_ID'] = $eflash->Module_ID;
        $data['TEST_DATETIME'] = $eflash->TEST_DATETIME;
        $data['PMAX'] = $eflash->PMAX;
        $data['FF'] = $eflash->FF;
        $data['VOC'] = $eflash->VOC;
        $data['ISC'] = $eflash->ISC;
        $data['VPM'] = $eflash->VPM;
        $data['IPM'] = $eflash->IPM;
        $data['RS'] = $eflash->RS;
        $data['RSH'] = $eflash->RSH;
        $data['EnvTemp'] = $eflash->EnvTemp;
        $data['SurfTemp'] = $eflash->SurfTemp;
        $data['Remark'] = $eflash->Remark;
        
        \App\Models\TRINA\MidFlash::where([
            ["WorkOrder_ID",$WorkOrder_ID],
            ["Module_ID",$Module_ID],
        ])->delete();

        $eflash = \App\Models\TRINA\MidFlash::insert($data);

        return Response::json($eflash);
    }
}
