<?php

namespace App\Http\Controllers\TRINA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TRINA\ModuleID;
use App\Models\TRINA\ModuleUpdateLog;

use Illuminate\Support\Facades\Auth;

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
}
