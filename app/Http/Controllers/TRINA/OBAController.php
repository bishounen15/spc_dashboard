<?php

namespace App\Http\Controllers\TRINA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\TRINA\OBA;
use App\Models\TRINA\OBAHistory;

use Response;

class OBAController extends Controller
{
    //
    public function saveOBA(Request $request) {
        $data = [];

        $data['Module_ID'] = $request->input('Module_ID');
        $data['Carton_no'] = $request->input('Carton_no');
        $data['Judgement'] = $request->input('Judgement');
        $data['Remarks'] = $request->input('Remarks') == null ? "" : $request->input('Remarks');

        $oba_history = OBAHistory::create($data);
        $oba = OBA::updateOrCreate(
            ['Module_ID' => $data['Module_ID'], 'Carton_no' => $data['Carton_no']],
            ['Judgement' => $data['Judgement'], 'Remarks' => $data['Remarks']]
        );

        return Response::json($oba);
    }
}
