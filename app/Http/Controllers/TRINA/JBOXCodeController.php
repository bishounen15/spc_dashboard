<?php

namespace App\Http\Controllers\TRINA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use DataTables;
use Response;

class JBOXCodeController extends Controller
{
    //
    public function index() {
        return view('mes.trina.admin.jbox');
    }

    public function verify(Request $request) {
        $Module_ID = $request->input("Module_ID");  
        $JBOX_Code = $request->input("JBOX_Code");

        $length = strlen($JBOX_Code);
        $code = substr($JBOX_Code,0,2);

        $jbox = DB::connection('trina')
                        ->select("SELECT B.Jbox_Suppliers, ? AS jbox_Code, B.Jbox_MID, ? AS length FROM rt_wo_mid A INNER JOIN df_wo_mat B ON A.WorkOrder_ID = B.WorkOrder_ID AND A.WorkOrder_vertion = B.WorkOrder_vertion WHERE A.Module_ID = ?",[$code, $length, $Module_ID]);

        $codes = DB::connection('trina')
                        ->select("SELECT Jbox_Suppliers, jbox_Code, Jbox_MID, length FROM df_jbox_code WHERE jbox_Code = ?",[$jbox[0]->jbox_Code]);

        return Response::json([$jbox,$codes]);
    }

    public function register(Request $request) {
        $data = [
            "Jbox_Suppliers" => $request->input("Jbox_Suppliers"),
            "jbox_Code" => $request->input("jbox_Code"),
            "Jbox_MID" => $request->input("Jbox_MID"),
            "length" => $request->input("length")
        ];

        $deleted = DB::connection("trina")
                        ->table("omes.df_jbox_code")
                        ->where("jbox_Code",$data["jbox_Code"])
                        ->delete();

        $registered = DB::connection("trina")
                        ->table("omes.df_jbox_code")
                        ->insert($data);

        return Response::json([$registered,$deleted]);
    }
}
