<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductionTeam as ProductionTeam;
use App\mesData as mesData;
use App\YieldData as YieldData;
use App\User as User;

use DataTables;
Use Response;

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
        date_default_timezone_set('Asia/Manila');
        $data = [];

        $data['team'] = "";

        $data['teams'] = $this->team;

        $date = date("Y-m-d",strtotime("Today"));
        $time = date('H:i');
        // $time = date('06:00');
        
        if ($time < "06:00") {
            $date = date("Y-m-d",strtotime("-1 days",strtotime($date)));
        }

        $shift = $this->getShift($time);
        
        $last_yield = YieldData::where("date",$date)->orderBy("id","desc")->first();
        // dd($shift);
        if ($last_yield != null) {
            if (($date != $last_yield->date || $shift != $last_yield->shift) && $this->getEnd($date,$last_yield->shift) != $last_yield->to ) {
                $date = $last_yield->date;
                $shift = $last_yield->shift;

                $dt = $this->getEnd($date,$last_yield->shift);
                // dd($dt);
            } else {
                $dt = date("Y-m-d",strtotime("Today")) . " " . $time;
            }
        } else {
            $dt = date("Y-m-d",strtotime("Today")) . " " . $time;
        }

        $last_trx = YieldData::where([
            ["date", $date],
            ["shift", $shift],
        ])->max("to");

        if ($last_trx == null) {
            $last_trx = $this->getStart($date,$shift);
        }

        // $last_trx = "2018-07-13 06:00";
        // $dt = "2018-07-13 14:00";
        
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

    private function getEnd($date, $shift) {
        if ($shift == "A") {
            $retval = $date . " 14:00:00";
        } else if ($shift == "B") {
            $retval = $date . " 22:00:00";
        } else {
            $retval = date("Y-m-d",strtotime("+1 days",strtotime($date))) . " 06:00:00";
        }

        return $retval;
    }

    public function load()
    {
        $yield = YieldData::selectRaw("YEAR(date) as yr, CONCAT('Q',QUARTER(date)) as qtr, CONCAT('W',WEEK(date,1)) as wk, CONCAT('W',WEEK(date,1),'.',WEEKDAY(date) + 1) as wkd, date, sum(input_cell) as input_cell, sum(input_mod) as input_mod, sum(inprocess_cell) as inprocess_cell, sum(ccd_cell) as ccd_cell, sum(visualdefect_cell) as visualdefect_cell, sum(cell_defect) as cell_defect, sum(cell_class_b) as cell_class_b, sum(cell_class_c) as cell_class_c, product_size as product_size, sum(str_produced) as str_produced, sum(str_defect) as str_defect, sum(el1_inspected) as el1_inspected, sum(el1_defect) as el1_defect, sum(be_inspected) as be_inspected, sum(be_defect) as be_defect, sum(be_class_b) as be_class_b, sum(be_class_c) as be_class_c, sum(man) as man, sum(mac) as mac, sum(mat) as mat, sum(met) as met, sum(env) as env, sum(el2_class_a) as el2_class_a, sum(el2_defect) as el2_defect, sum(el2_class_b) as el2_class_b, sum(el2_class_c) as el2_class_c, sum(el2_low_power) as el2_low_power, build, target, ROUND(AVG(py),2) as py, ROUND(AVG(ey),2) ey")
        ->orderByRaw("date ASC")
        ->groupBy("date","build","target", "product_size");

        return Datatables::of($yield)->make(true);
    }

    public function GetYieldPerDate(Request $request) {
        $trx_info = [];
        $data = [];
        $trx = YieldData::where("date",$request->input("date"))->get();
        
        foreach($trx as $detail) {
            $t = YieldData::find($detail->id);

            $data["from"] = $detail->from;
            $data["to"] = $detail->to;
            $data["input_cell"] = $detail->input_cell;
            $data["input_mod"] = $detail->input_mod;
            $data["inprocess_cell"] = $detail->inprocess_cell;
            $data["ccd_cell"] = $detail->ccd_cell;
            $data["visualdefect_cell"] = $detail->visualdefect_cell;
            $data["cell_defect"] = $detail->cell_defect;
            $data["cell_class_b"] = $detail->cell_class_b;
            $data["cell_class_c"] = $detail->cell_class_c;
            $data["product_size"] = $detail->product_size;
            $data["str_produced"] = $detail->str_produced;
            $data["str_defect"] = $detail->str_defect;
            $data["el1_inspected"] = $detail->el1_inspected;
            $data["el1_defect"] = $detail->el1_defect;
            $data["be_inspected"] = $detail->be_inspected;
            $data["be_defect"] = $detail->be_defect;
            $data["be_class_b"] = $detail->be_class_b;
            $data["be_class_c"] = $detail->be_class_c;
            $data["man"] = $detail->man;
            $data["mac"] = $detail->mac;
            $data["mat"] = $detail->mat;
            $data["met"] = $detail->met;
            $data["env"] = $detail->env;
            $data["el2_class_a"] = $detail->el2_class_a;
            $data["el2_class_a_crack"] = 0;
            $data["el2_defect"] = $detail->el2_defect;
            $data["el2_class_b"] = $detail->el2_class_b;
            $data["el2_class_c"] = $detail->el2_class_c;
            $data["el2_low_power"] = $detail->el2_low_power;
            $data["build"] = $detail->build;
            $data["target"] = $detail->target;
            $data["py"] = $detail->py;
            $data["ey"] = $detail->ey;

            $encoder = User::find($t->audits->first()->user_id);
            $data["user"] = $encoder->name;
            
            array_push($trx_info, $data);
        }
        return Response::json($trx_info);
    }
}
