<?php

namespace App\Http\Controllers\TRINA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TRINA\WorkOrder;

use DataTables;
use DB;

class WorkOrderController extends Controller
{
    //
    public function __construct()
    {
        date_default_timezone_set('Asia/Manila');
    }   
    
    public function index()
    {
        //
        return view('mes.trina.workorder.index');
    }

    private function WODropList($field) {
        $list = DB::connection('trina')->select("SELECT PRIDISPLAYNAME AS code, PRISOURCENAME AS descr FROM df_config_condition_linkage WHERE LINKDESCRIPTION = ? ORDER BY CAST(PRISEQUENCE AS UNSIGNED)",[$field]);

        return $list;
    }

    public function load() {
        $wo = DB::connection("trina")->select("SELECT A.WorkOrder_ID, A.WorkOrder_vertion, A.OrderID, A.Product_ID, B.Product_Type, A.Cell_Suppliers, A.Module_Colour, A.IsBonded, A.State FROM df_wo_mat A INNER JOIN df_pid_type_mapping B ON A.Product_ID = B.Q1_ID WHERE A.WorkOrder_ID LIKE 'S%' ORDER BY WorkOrder_ID");

        return Datatables::of($wo)->make(true);
    }

    public function show($id, $version) {
        $data = [];

        $data['wo'] = WorkOrder::where([
            ["WorkOrder_ID",$id],
            ["WorkOrder_vertion",$version]
        ])->first();

        $data['isBondedList'] = $this->WODropList('BuildWOinfo.ModuleIsBonded');
        $data['cellSup'] = $this->WODropList('BuildWOinfo.Cell_Suppliers');
        $data['modColor'] = $this->WODropList('BuildWOinfo.Module_Colour');
        // BuildWOinfo.Module_Colour

        return view('mes.trina.workorder.form', $data);
    }
}
