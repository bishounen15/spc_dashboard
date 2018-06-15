<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductionTeam as ProductionTeam;
use App\mesData as mesData;
use App\YieldData as YieldData;

class yieldController extends Controller
{
    //
    public function __construct( ProductionTeam $team )
    {
        $this->team = $team->all();
    }    

    public function create(Request $request) {
        $data = [];

        $data['team'] = $request->input('team');

        $data['teams'] = $this->team;

        $date = date("Y-m-d",strtotime("Today"));
        $time = date('h:i');

        if ($time < "06:00") {
            $date = date("Y-m-d",strtotime("-1 days",strtotime($date)));
        }

        $shift = $this->getShift($time);

        $last_trx = YieldData::where([
            ["date", $date],
            ["shift", $shift],
        ])->max("last_extract");

        if ($last_trx == null) {
            $last_trx = $this->getStart($date,$shift);
        }

        $dt = date("Y-m-d h:i",strtotime("Today"));

        $input_mod = mesData::whereRaw("TRXDATE BETWEEN '".$last_trx."' AND '".$dt."' AND LOCNCODE = 'PRELAM'")->count('SERIALNO');
        $be_class_b = mesData::whereRaw("TRXDATE BETWEEN '".$last_trx."' AND '".$dt."' AND LOCNCODE = 'VI1' AND MODCLASS = 'B'")->count('SERIALNO');
        $be_class_c = mesData::whereRaw("TRXDATE BETWEEN '".$last_trx."' AND '".$dt."' AND LOCNCODE = 'VI1' AND MODCLASS = 'C'")->count('SERIALNO');

        $el2_class_a = mesData::whereRaw("TRXDATE BETWEEN '".$last_trx."' AND '".$dt."' AND LOCNCODE = 'TEST-EL' AND MODCLASS = 'A'")->count('SERIALNO');
        $el2_class_b = mesData::whereRaw("TRXDATE BETWEEN '".$last_trx."' AND '".$dt."' AND LOCNCODE = 'TEST-EL' AND MODCLASS = 'B'")->count('SERIALNO');
        $el2_class_c = mesData::whereRaw("TRXDATE BETWEEN '".$last_trx."' AND '".$dt."' AND LOCNCODE = 'TEST-EL' AND MODCLASS = 'C'")->count('SERIALNO');

        $data['trxdate'] = $date;
        $data['shift'] = $shift;
        $data['input_mod'] = $input_mod;
        $data['be_inspected'] = $input_mod;
        $data['be_defect'] = $be_class_b + $be_class_c;
        $data['be_class_b'] = $be_class_b;
        $data['be_class_c'] = $be_class_c;
        $data['el2_class_a'] = $el2_class_a;
        $data['el2_class_c'] = $el2_class_c;
        $data['el2_class_b'] = $el2_class_b;
        $data['be_class_c'] = $be_class_c;

        return view('yield.form', $data);
    }

    private function getShift($time) {
        if ($time >= "06:00" && $time <= "13:59") {
            $retval = "A";
        } else if ($time >= "14:00" && $time <= "21:59") {
            $retval = "B";
        } else {
            $retval = "C";
        }

        return $retval;
    }

    private function getStart($date, $shift) {
        if ($shift == "A") {
            $retval = $date . " 06:00";
        } else if ($shift == "B") {
            $retval = $date . " 14:00";
        } else {
            $retval = $date . " 22:00";
        }

        return $retval;
    }
}
