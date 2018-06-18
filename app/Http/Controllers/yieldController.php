<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductionTeam as ProductionTeam;
use App\mesData as mesData;
use App\YieldData as YieldData;

use DataTables;

class yieldController extends Controller
{
    //
    public function __construct( ProductionTeam $team )
    {
        $this->team = $team->all();
    }    

    public function list() {
        return view('yield.list');
    }

    public function create() {
        $data = [];

        $data['team'] = "";

        $data['teams'] = $this->team;

        $date = date("Y-m-d",strtotime("-3 Days"));
        $time = date('H:i');
        // $time = date('06:00');
        
        if ($time < "06:00") {
            $date = date("Y-m-d",strtotime("-1 days",strtotime($date)));
        }

        $shift = $this->getShift($time);

        $last_trx = YieldData::where([
            ["date", $date],
            ["shift", $shift],
        ])->max("to");

        if ($last_trx == null) {
            $last_trx = $this->getStart($date,$shift);
        }

        $dt = date("Y-m-d",strtotime("-3 Days")) . " " . $time;
        // $dt = date("Y-m-d 06:00",strtotime("-4 Days"));

        // dd($dt);
        
        $input_mod = mesData::where([
            ["TRXDATE",">=",$last_trx],
            ["TRXDATE","<",$dt],
            ["LOCNCODE","=","PRELAM"],
        ])->count("SERIALNO");

        $be_class_b = mesData::where([
            ["TRXDATE",">=",$last_trx],
            ["TRXDATE","<",$dt],
            ["LOCNCODE","=","VI1"],
            ["MODCLASS","=","B"],
        ])->count("SERIALNO");

        $be_class_c = mesData::where([
            ["TRXDATE",">=",$last_trx],
            ["TRXDATE","<",$dt],
            ["LOCNCODE","=","VI1"],
            ["MODCLASS","=","C"],
        ])->count("SERIALNO");
        
        $el2_class_a = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")->where([
            ["lbl02.LBLTYPE","=",1],
            ["mes01.TRXDATE",">=",$last_trx],
            ["mes01.TRXDATE","<",$dt],
            ["mes01.LOCNCODE","=","TEST-EL"],
            ["lbl02.MODCLASS","=","A"],
        ])->count("mes01.SERIALNO");

        $el2_class_b = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")->where([
            ["lbl02.LBLTYPE","=",1],
            ["mes01.TRXDATE",">=",$last_trx],
            ["mes01.TRXDATE","<",$dt],
            ["mes01.LOCNCODE","=","TEST-EL"],
            ["lbl02.MODCLASS","=","B"],
        ])->count("mes01.SERIALNO");

        $el2_class_c = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")->where([
            ["lbl02.LBLTYPE","=",1],
            ["mes01.TRXDATE",">=",$last_trx],
            ["mes01.TRXDATE","<",$dt],
            ["mes01.LOCNCODE","=","TEST-EL"],
            ["lbl02.MODCLASS","=","C"],
        ])->count("mes01.SERIALNO");

        $data['trxdate'] = $date;
        $data['shift'] = $shift;

        $data['from'] = $last_trx;
        $data['to'] = $dt;

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

    public function store(Request $request) {
        $data = [];

        $data['team'] = $request->input('team');
        $data['date'] = $request->input('date');
        $data['shift'] = $request->input('shift');
        $data['from'] = $request->input('from');
        $data['to'] = $request->input('to');
        $data['build'] = $request->input('build');
        $data['target'] = $request->input('target');
        $data['product_size'] = $request->input('product_size');
        $data['input_cell'] = $request->input('input_cell');
        $data['input_mod'] = $request->input('input_mod');
        $data['inprocess_cell'] = $request->input('inprocess_cell');
        $data['ccd_cell'] = $request->input('ccd_cell');
        $data['visualdefect_cell'] = $request->input('visualdefect_cell');
        $data['cell_defect'] = $request->input('cell_defect');
        $data['cell_class_b'] = $request->input('cell_class_b');
        $data['cell_class_c'] = $request->input('cell_class_c');
        $data['str_produced'] = $request->input('str_produced');
        $data['str_defect'] = $request->input('str_defect');
        $data['el1_inspected'] = $request->input('el1_inspected');
        $data['el1_defect'] = $request->input('el1_defect');
        $data['be_inspected'] = $request->input('be_inspected');
        $data['be_defect'] = $request->input('be_defect');
        $data['be_class_b'] = $request->input('be_class_b');
        $data['be_class_c'] = $request->input('be_class_c');
        $data['el2_class_a'] = $request->input('el2_class_a');
        $data['el2_defect'] = $request->input('el2_defect');
        $data['el2_class_b'] = $request->input('el2_class_b');
        $data['el2_class_c'] = $request->input('el2_class_c');
        $data['el2_low_power'] = $request->input('el2_low_power');
        $data['man'] = $request->input('man');
        $data['mac'] = $request->input('mac');
        $data['mat'] = $request->input('mat');
        $data['met'] = $request->input('met');
        $data['env'] = $request->input('env');
        $data['total_4m'] = $request->input('total_4m');
        $data['total_defect'] = $request->input('total_defect');
        $data['py'] = $request->input('py');
        $data['ey'] = $request->input('ey');
        $data['srr'] = $request->input('srr');
        $data['mrr'] = $request->input('mrr');

        // dd($data);

        YieldData::create($data);
        return redirect('/Yield/list')->with("success","Record Successfully Created.");
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

    public function load()
    {
        $yield = YieldData::selectRaw("id, YEAR(date) as yr, CONCAT('Q',QUARTER(date)) as qtr, CONCAT('W',WEEK(date,1)) as wk, CONCAT('W',WEEK(date,1),'.',WEEKDAY(date) + 1) as wkd, date, input_cell, input_mod, inprocess_cell, ccd_cell, visualdefect_cell, cell_defect, cell_class_b, cell_class_c, product_size, str_produced, str_defect, el1_inspected, el1_defect, be_inspected, be_defect, be_class_b, be_class_c, man, mac, mat, met, env, el2_class_a, el2_defect, el2_class_b, el2_class_c, el2_low_power, build, target, ROUND(py,2) as py, ey")
        ->orderByRaw("date ASC, shift ASC");

        return Datatables::of($yield)->make(true);
    }
}
