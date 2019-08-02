<?php

namespace App\Http\Controllers\WebPortal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WebPortal\ProductionLine;
use App\Models\WebPortal\IPAssign;
use DB;
use Request as Req;

class LotRecordsController extends Controller
{
    //
    public function index() {
        $assignment = IPAssign::where("IPADDRESS",Req::ip())->first();

        $materials = DB::connection('web_portal')
                            ->table('mlt00')
                            ->where('LOCNCODE',$assignment->STATION)
                            ->orderBy("ROWID","ASC")
                            ->get();

        $mats = [];
        $data = [];
        $i = 1;

        foreach($materials as $mat) {
            $details = [];

            $details['index'] = $i;
            $details['field'] = "LOT0".$i;
            $details['caption'] = $mat->MATERIAL;

            array_push($mats,$details);

            $i++;
        }

        $data['materials'] = json_encode($mats);

        $prodline = ProductionLine::where("LINCODE",$assignment->PRODLINE)->first();
        $data['prodline'] = $prodline;

        $data['station'] = $assignment->STATION;

        return view('mes.transactions.lot', $data);
    }
}
