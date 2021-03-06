<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductionTeam as ProductionTeam;
use App\mesData as mesData;
use App\YieldData as YieldData;
use App\ProductTypes;
use App\User as User;
use App\YieldEmail;
use App\Models\Planning\ProductionSchedule;
use App\Models\WebPortal\ProductionLine;

use Illuminate\Support\Facades\Auth;

use DB;
use DataTables;
Use Response;
use Carbon\Carbon;

use App\Jobs\UpdateNotification;

class yieldController extends Controller
{
    //
    public function __construct( ProductionTeam $team )
    {
        date_default_timezone_set('Asia/Manila');
        $this->team = $team->all();
    }    

    public function list() {
        return view('yield.list');
    }

    private function processShift(&$shift, &$schedshift, &$date) {
        if ($shift == $schedshift->first()->details->descr) {
            $fval = $this->getStart($date,$shift,$schedshift) . ":00";
            $tval = date("Y-m-d",strtotime($date)) . " " . $time . ":00";

            $to = Carbon::createFromFormat('Y-m-d H:i:s', $tval);
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $fval);
            
            $diff_in_minutes = $to->diffInMinutes($from);
            
            if ($diff_in_minutes < 30) {
                $date = date("Y-m-d",strtotime("-1 days",strtotime($date)));
            }
        }
    }

    private function processLastYield(&$last_yield, &$date, &$shift, &$time, &$schedshift) {
        if ($last_yield != null) {
            if (($date != $last_yield->date || $shift != $last_yield->shift) && $this->getEnd($date,$last_yield->shift) != $last_yield->to ) {
                $date = $last_yield->date;
                $shift = $last_yield->shift;
                
                $dt = $this->getEnd($date,$last_yield->shift) . ":00";
                $cdt = date("Y-m-d",strtotime("Today")) . " " . $time . ":00";
                
                $to = Carbon::createFromFormat('Y-m-d H:i:s', $cdt);
                $from = Carbon::createFromFormat('Y-m-d H:i:s', $dt);
                
                $diff_in_minutes = $to->diffInMinutes($from);
                
                if ($diff_in_minutes >= 30) {
                    $shift = $this->getShift($time,$schedshift);
                    $last_trx = $this->getStart($date,$shift,$schedshift);
                    $dt = date("Y-m-d",strtotime("Today")) . " " . $time;
                }
            } else {
                $dt = date("Y-m-d",strtotime("Today")) . " " . $time;
            }
        } else {
            $shifts = ProductionSchedule::whereBetween("production_date",[
                    date("Y-m-d",strtotime("-1 days",strtotime($date))),
                    $date
                ])->orderBy("production_date","DESC")->get();
            
            $found = false;
            $got = false;
            
            foreach($shifts as $sc) {
                foreach($sc->selectedShifts()->orderBy("shift_id","DESC")->get() as $sd) {
                    if ($sd->details->descr == $shift) {
                        $found = true;
                        continue;
                    }

                    if ($found == true) {
                        $shift = $sd->details->descr;
                        $got = true;
                        break;
                    }
                }

                if ($got == true) { break; }
            }

            $dt = $this->getEnd($date,$shift) . ":00";
            // $cdt = date("Y-m-d",strtotime("+1 days",strtotime("Today"))) . " " . $time . ":00";
            $cdt = date("Y-m-d",strtotime("Today")) . " " . $time . ":00";

            $to = Carbon::createFromFormat('Y-m-d H:i:s', $cdt);
            $from = Carbon::createFromFormat('Y-m-d H:i:s', $dt);
            
            $diff_in_minutes = $to->diffInMinutes($from);
            
            if ($diff_in_minutes >= 30) {
                $shift = $this->getShift($time,$schedshift);
                $last_trx = $this->getStart($date,$shift,$schedshift);
                $dt = date("Y-m-d",strtotime("Today")) . " " . $time;
            } else {
                $dt = $this->getEnd($date,$shift);
            }
        }

        return $dt;
    }

    public function create($id = null) {
        
        $data = [];

        $data['id'] = $id;
        $data['prod_types'] = ProductTypes::all();
        $data['prod_lines'] = ProductionLine::all();
        $data['production_line'] = null;
        $data['team'] = null;
        $data['product_size'] = null;
        $data['input_cell'] = 0;

        $data['build'] = "";
        $data['target'] = "";

        $data['inprocess_cell'] = 0;
        $data['ccd_cell'] = 0;
        $data['visualdefect_cell'] = 0;
        $data['cell_defect'] = 0;
        $data['cell_class_b'] = 0;
        $data['cell_class_c'] = 0;

        $data['str_produced'] = 0;
        $data['str_defect'] = 0;

        $data['el1_inspected'] = 0;
        $data['el1_defect'] = 0;

        $data['be_inspected'] = 0;
        $data['be_defect'] = 0;
        $data['be_class_b'] = 0;
        $data['be_class_c'] = 0;

        $data['el2_class_a'] = 0;
        $data['el2_defect'] = 0;
        $data['el2_class_b'] = 0;
        $data['el2_class_c'] = 0;
        $data['el2_low_power'] = 0;

        $data['man'] = 0;
        $data['mac'] = 0;
        $data['mat'] = 0;
        $data['met'] = 0;
        $data['env'] = 0;
        $data['total_4m'] = 0;
        $data['total_defect'] = 0;

        $data['teams'] = $this->team;

        if ($id == null) {
            $date = date("Y-m-d",strtotime("Today"));
            // $date = date("Y-m-d",strtotime("+1 days",strtotime("Today")));
            $time = date('H:i');
            // $time = date('06:29');
            
            if ($time < "06:00") {
                $date = date("Y-m-d",strtotime("-1 days",strtotime($date)));
            }
            
            $schedshift = ProductionSchedule::where("production_date",$date)->first()->selectedShifts()->get();
            $data['schedshift'] = $schedshift;

            $shift = $this->getShift($time, $schedshift);
            $this->processShift($sched, $schedshift, $date);

            $last_yield = YieldData::where("date",$date)->orderBy("id","desc")->first();
            $dt = $this->processLastYield($last_yield, $date, $shift, $time, $schedshift);

            $last_trx = YieldData::where([
                ["date", $date],
                ["shift", $shift],
            ])->max("to");

            if ($last_trx == null) {
                $last_trx = $this->getStart($date,$shift,$schedshift);
            }
        } else {
            $yield_data = YieldData::find($id);

            $last_trx = $yield_data->from;
            $dt = $yield_data->to;
            $date = $yield_data->date;
            $shift = $yield_data->shift;

            $schedshift = ProductionSchedule::where("production_date",$date)->first()->selectedShifts()->get();
            $data['schedshift'] = $schedshift;

            $data['team'] = $yield_data->team;
            $data['product_size'] = $yield_data->product_size;
            $data['production_line'] = $yield_data->production_line;
            $data['input_cell'] = $yield_data->input_cell;

            $data['build'] = $yield_data->build;
            $data['target'] = $yield_data->target;

            $data['inprocess_cell'] = $yield_data->inprocess_cell;
            $data['ccd_cell'] = $yield_data->ccd_cell;
            $data['visualdefect_cell'] = $yield_data->visualdefect_cell;
            $data['cell_defect'] = $yield_data->cell_defect;
            $data['cell_class_b'] = $yield_data->cell_class_b;
            $data['cell_class_c'] = $yield_data->cell_class_c;

            $data['str_produced'] = $yield_data->str_produced;
            $data['str_defect'] = $yield_data->str_defect;

            $data['el1_inspected'] = $yield_data->el1_inspected;
            $data['el1_defect'] = $yield_data->el1_defect;

            $data['el2_defect'] = $yield_data->el2_defect;
            $data['el2_low_power'] = $yield_data->el2_low_power;

            $data['man'] = $yield_data->man;
            $data['mac'] = $yield_data->mac;
            $data['mat'] = $yield_data->mat;
            $data['met'] = $yield_data->met;
            $data['env'] = $yield_data->env;
            $data['total_4m'] = $yield_data->total_4m;
            $data['total_defect'] = $yield_data->total_defect;
        }

        $input_mod = mesData::where([
            ["TRXDATE",">=",$last_trx],
            ["TRXDATE","<",$dt],
            ["LOCNCODE","=","PRELAM"],
            ["PRODLINE","=",$data['production_line']],
        ])->count("SERIALNO");

        $be_class_b = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")
                        ->where([ 
                            ["mes01.TRXDATE",">=",$last_trx], 
                            ["mes01.TRXDATE","<",$dt], 
                            ["mes01.LOCNCODE","=","VI1"],
                            ["mes01.PRODLINE","=",$data['production_line']], 
                            ["lbl02.MODCLASS","=","B"], 
                            ["lbl02.LBLTYPE","=","1"], 
                            ])->count("mes01.SERIALNO");

        $be_class_c = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")
                        ->where([ 
                            ["mes01.TRXDATE",">=",$last_trx], 
                            ["mes01.TRXDATE","<",$dt], 
                            ["mes01.LOCNCODE","=","VI1"],
                            ["mes01.PRODLINE","=",$data['production_line']], 
                            ["lbl02.MODCLASS","=","C"], 
                            ["lbl02.LBLTYPE","=","1"], 
                            ])->count("mes01.SERIALNO");
        
        $el2_class_a = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")->where([
            ["lbl02.LBLTYPE","=",1],
            ["mes01.TRXDATE",">=",$last_trx],
            ["mes01.TRXDATE","<",$dt],
            ["mes01.LOCNCODE","=","TEST-EL"],
            ["mes01.PRODLINE","=",$data['production_line']],
            ["lbl02.MODCLASS","=","A"],
        ])->count("mes01.SERIALNO");

        $el2_class_b = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")
            ->join("mes01 as vi1",[
                ["lbl02.SERIALNO","=","vi1.SERIALNO"],
                ["vi1.LOCNCODE","=",DB::raw("'VI1'")],
            ])
            ->where([
                ["lbl02.LBLTYPE","=",1],
                ["mes01.TRXDATE",">=",$last_trx],
                ["mes01.TRXDATE","<",$dt],
                ["mes01.LOCNCODE","=","TEST-EL"],
                ["mes01.PRODLINE","=",$data['production_line']],
                ["lbl02.MODCLASS","=","B"],
                [DB::raw("CASE WHEN vi1.SNOSTAT = 1 AND vi1.MODCLASS = '' THEN (SELECT MCLCODE FROM cls01 WHERE CUSTOMER = lbl02.CUSTOMER AND MODSTATUS = 0 ORDER BY MCLCODE DESC LIMIT 1) ELSE vi1.MODCLASS END"),"<>","B"],
            ])->count("mes01.SERIALNO");

        $el2_class_c = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")
            ->join("mes01 as vi1",[
                ["lbl02.SERIALNO","=","vi1.SERIALNO"],
                ["vi1.LOCNCODE","=",DB::raw("'VI1'")],
            ])
            ->where([
                ["lbl02.LBLTYPE","=",1],
                ["mes01.TRXDATE",">=",$last_trx],
                ["mes01.TRXDATE","<",$dt],
                ["mes01.LOCNCODE","=","TEST-EL"],
                ["mes01.PRODLINE","=",$data['production_line']],
                ["lbl02.MODCLASS","=","C"],
                ["vi1.MODCLASS","<>","C"],
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
        
        return view('yield.form', $data);
    }

    public function store(Request $request) {
        $data = [];

        $data['team'] = $request->input('team');
        $data['date'] = $request->input('date');
        $data['shift'] = $request->input('shift');
        $data['production_line'] = $request->input('production_line');
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

    public function modify(Request $request, $id) {
        $yield_data = YieldData::find($id);

        $yield_data->team = $request->input('team');
        $yield_data->date = $request->input('date');
        $yield_data->shift = $request->input('shift');
        $yield_data->from = $request->input('from');
        $yield_data->to = $request->input('to');
        $yield_data->build = $request->input('build');
        $yield_data->target = $request->input('target');
        $yield_data->product_size = $request->input('product_size');
        $yield_data->input_cell = $request->input('input_cell');
        $yield_data->input_mod = $request->input('input_mod');
        $yield_data->inprocess_cell = $request->input('inprocess_cell');
        $yield_data->ccd_cell = $request->input('ccd_cell');
        $yield_data->visualdefect_cell = $request->input('visualdefect_cell');
        $yield_data->cell_defect = $request->input('cell_defect');
        $yield_data->cell_class_b = $request->input('cell_class_b');
        $yield_data->cell_class_c = $request->input('cell_class_c');
        $yield_data->str_produced = $request->input('str_produced');
        $yield_data->str_defect = $request->input('str_defect');
        $yield_data->el1_inspected = $request->input('el1_inspected');
        $yield_data->el1_defect = $request->input('el1_defect');
        $yield_data->be_inspected = $request->input('be_inspected');
        $yield_data->be_defect = $request->input('be_defect');
        $yield_data->be_class_b = $request->input('be_class_b');
        $yield_data->be_class_c = $request->input('be_class_c');
        $yield_data->el2_class_a = $request->input('el2_class_a');
        $yield_data->el2_defect = $request->input('el2_defect');
        $yield_data->el2_class_b = $request->input('el2_class_b');
        $yield_data->el2_class_c = $request->input('el2_class_c');
        $yield_data->el2_low_power = $request->input('el2_low_power');
        $yield_data->man = $request->input('man');
        $yield_data->mac = $request->input('mac');
        $yield_data->mat = $request->input('mat');
        $yield_data->met = $request->input('met');
        $yield_data->env = $request->input('env');
        $yield_data->total_4m = $request->input('total_4m');
        $yield_data->total_defect = $request->input('total_defect');
        $yield_data->py = $request->input('py');
        $yield_data->ey = $request->input('ey');
        $yield_data->srr = $request->input('srr');
        $yield_data->mrr = $request->input('mrr');
        $yield_data->remarks = $request->input('remarks');

        $yield_data->update();

        $emails = YieldEmail::all();

        $receiverAddress = [];

        foreach ($emails as $email) {
            array_push($receiverAddress,$email->email);
        }
        
        $t = YieldData::find($id);
        $changes = $t->audits->where("event","updated")->last();
        $last_edit = [];

        foreach($changes->getModified() as $key => $value) {
            $old = $value["old"];
            $new = $value["new"];

            array_push($last_edit,["field" => $key, "old" => $old, "new" => $new,]);
        }

        $newEmailSubject = 'Yield Record was Updated';
        $content = [
        'title'=> 'Yield Details for the below record has been updated.',
        'details' => 'The transaction below was updated by',
        'team' => $request->input('team'),
        'date' => $request->input('date'),
        'shift' => $request->input('shift'),
        'updated_by' => '['.Auth::user()->user_id . " - " . Auth::user()->name.']',
        'remarks' => $request->input('remarks'),
        'last_edit' => $last_edit,
        'button' => 'Click Here'
        ];


        $job = (new UpdateNotification($content, $receiverAddress, $newEmailSubject))
                ->delay(now()->addSeconds(5));
        
        dispatch($job);

        return redirect('/Yield/list')->with("success","Record Successfully Updated.");
    }

    private function getShift($time, $sched) {
        $retval = "";

        $date = date("Y-m-d",strtotime("Today"));
        $sdate = $date;

        if ($time < "06:00") {
            $date = date("Y-m-d",strtotime("1 days",strtotime($date)));
        }
        
        $edate = $sdate;

        foreach($sched as $shift) {
            if ($shift->details->overday == 1) {
                $edate = date("Y-m-d",strtotime("1 days",strtotime($sdate)));
            }
            
            if ($date . " " . $time >= $sdate . " " . date("H:i",strtotime($shift->details->start_time)) && $date . " " . $time < $edate . " " . date("H:i",strtotime($shift->details->end_time))) {
                $retval = $shift->details->descr;
                break;
            }
        }
        
        return $retval;
    }

    private function getStart($date, $shift, $sched) {
        $retval = "";
        foreach($sched as $sc) {
            if ($sc->details->descr == $shift) {
                $stime = $sc->details->start_time;
                $retval = $date . " " . date("H:i",strtotime($stime));
                break;
            }
        }

        return $retval;
    }

    private function getEnd($date, $shift) {
        $sched = ProductionSchedule::where("production_date",$date)->first()->selectedShifts()->get();
        $retval = "";

        foreach($sched as $sc) {
            if ($sc->details->descr == $shift) {
                $etime = $sc->details->end_time;
                if ($sc->details->overday == 1) {
                    $retval = date("Y-m-d",strtotime("+1 days",strtotime($date))) . " " . date("H:i",strtotime($etime));
                } else {
                    $retval = $date . " " . date("H:i",strtotime($etime));
                }
                break;
            }
        }

        return $retval;
    }

    public function load()
    {
        $lines = ProductionLine::all();
        $lsrc = "";

        foreach($lines as $line) {
            $lsrc .= ($lsrc == "" ? "" : " UNION ALL ") . "SELECT " . $line->LINCODE . " AS LINCODE, '" . $line->LINDESC . "' AS LINDESC";
        }

        $yield = YieldData::selectRaw("YEAR(date) as yr, CONCAT('Q',QUARTER(date)) as qtr, CONCAT('W',WEEK(date,1)) as wk, CONCAT('W',WEEK(date,1),'.',WEEKDAY(date) + 1) as wkd, date, lin01.LINDESC AS production_line, sum(input_cell) as input_cell, sum(input_mod) as input_mod, sum(inprocess_cell) as inprocess_cell, sum(ccd_cell) as ccd_cell, sum(visualdefect_cell) as visualdefect_cell, sum(cell_defect) as cell_defect, sum(cell_class_b) as cell_class_b, sum(cell_class_c) as cell_class_c, product_size as product_size, sum(str_produced) as str_produced, sum(str_defect) as str_defect, sum(el1_inspected) as el1_inspected, sum(el1_defect) as el1_defect, sum(be_inspected) as be_inspected, sum(be_defect) as be_defect, sum(be_class_b) as be_class_b, sum(be_class_c) as be_class_c, sum(man) as man, sum(mac) as mac, sum(mat) as mat, sum(met) as met, sum(env) as env, sum(el2_class_a) as el2_class_a, sum(el2_defect) as el2_defect, sum(el2_class_b) as el2_class_b, sum(el2_class_c) as el2_class_c, sum(el2_low_power) as el2_low_power, build, target, IFNULL(ROUND(((SUM(input_cell) - (SUM(inprocess_cell) + SUM(ccd_cell) + SUM(visualdefect_cell) + SUM(cell_defect))) / SUM(input_cell)) * 100 , 2),0) as py, IFNULL(ROUND(((SUM(input_cell) - (SUM(inprocess_cell) + SUM(ccd_cell) + SUM(visualdefect_cell) + SUM(cell_class_c))) / SUM(input_cell)) * 100 , 2),0) as ey, IFNULL(ROUND((SUM(str_defect) / SUM(str_produced)) * 100,2),0) as srr, IFNULL(ROUND((SUM(el1_defect) / SUM(el1_inspected)) * 100,2),0) as mrr")
        ->leftJoin(DB::raw("(".$lsrc.") AS lin01"),"yield_datas.production_line","lin01.LINCODE")
        ->orderByRaw("date DESC")
        ->groupBy("date", "lin01.LINDESC","build","target", "product_size");

        return Datatables::of($yield)->make(true);
    }

    public function GetYieldPerDate(Request $request) {
        $lines = ProductionLine::all();
        $lsrc = "";

        foreach($lines as $line) {
            $lsrc .= ($lsrc == "" ? "" : " UNION ALL ") . "SELECT " . $line->LINCODE . " AS LINCODE, '" . $line->LINDESC . "' AS LINDESC";
        }

        $trx_info = [];
        $data = [];
        $trx = YieldData::leftJoin(DB::raw("(".$lsrc.") AS lin01"),"yield_datas.production_line","lin01.LINCODE")
                          ->where([
                                ["date",$request->input("date")],
                                ["lin01.LINDESC",$request->input("prodline")],
                            ])->get();
        
        foreach($trx as $detail) {
            $t = YieldData::find($detail->id);

            $edits = $t->audits->where("event","updated")->count();
            $data["edits"] = $edits;

            $data["id"] = $detail->id;
            $data["team"] = $detail->team;
            $data["from"] = $detail->from;
            $data["to"] = $detail->to;
            $data["date"] = $detail->date;
            $data["shift"] = $detail->shift;
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

            $data["created_at"] = date("Y-m-d H:m:s",strtotime($detail->created_at));
            
            array_push($trx_info, $data);
        }
        return Response::json($trx_info);
    }

    public function getShiftOutput(Request $request) {
        // return Response::json($request);
        $date = $request->input('date');
        $shift = $request->input('shift');
        $build = $request->input('build');
        $prodline = $request->input('production_line');

        $schedshift = ProductionSchedule::where("production_date",$request->input('date'))->first()->selectedShifts()->get();

        if ($request->input('current') == "true") {
            $last_trx = YieldData::where([
                ["date", $date],
                ["shift", $shift],
                ["production_line", $prodline],
            ])->max("to");

            if ($last_trx == null) {
                $last_trx = $this->getStart($date,$shift,$schedshift);
            }

            $start =  $last_trx; //$request->input('from');
            $end = $request->input('to');
        } else {
            $start = $this->getStart($request->input('date'),$request->input('shift'),$schedshift);
            $end = $this->getEnd($request->input('date'),$request->input('shift'));
        }
        $data = [];

        $data['schedshift'] = $schedshift;

        $data["start"] = $start;
        $data["end"] = $end;

        $last_trx = $start;
        $dt = $end;
        
        $input_mod = mesData::where([
            ["TRXDATE",">=",$last_trx],
            ["TRXDATE","<",$dt],
            ["LOCNCODE","=","PRELAM"],
            ["PRODLINE","=",$prodline],
        ])->count("SERIALNO");

        $be_class_b = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")
                        ->where([ 
                            ["mes01.TRXDATE",">=",$last_trx], 
                            ["mes01.TRXDATE","<",$dt], 
                            ["mes01.LOCNCODE","=","VI1"], 
                            ["mes01.PRODLINE","=",$prodline],
                            ["lbl02.MODCLASS","=","B"], 
                            ["lbl02.LBLTYPE","=","1"], 
                            ])->count("mes01.SERIALNO");

        $be_class_c = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")
                        ->join("mes01 as test",[
                            ["lbl02.SERIALNO","=","test.SERIALNO"],
                            ["test.LOCNCODE","=",DB::raw("'TEST-EL'")],
                        ])
                        ->where([ 
                            ["mes01.TRXDATE",">=",$last_trx], 
                            ["mes01.TRXDATE","<",$dt], 
                            ["mes01.LOCNCODE","=","VI1"], 
                            ["mes01.PRODLINE","=",$prodline],
                            ["lbl02.MODCLASS","=", ($build == "GT" ? "C" : "") ], 
                            ["lbl02.LBLTYPE","=","1"],
                            ["test.MODCLASS","<>",($build == "GT" ? "C" : "")], 
                            ])->count("mes01.SERIALNO");
        
        $el2_class_a = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")->where([
            ["lbl02.LBLTYPE","=",1],
            ["mes01.TRXDATE",">=",$last_trx],
            ["mes01.TRXDATE","<",$dt],
            ["mes01.LOCNCODE","=","TEST-EL"],
            ["mes01.PRODLINE","=",$prodline],
        ])->whereIn('lbl02.MODCLASS', ["A","A+"])->count("mes01.SERIALNO");

        $el2_class_b = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")
            ->join("mes01 as vi1",[
                ["lbl02.SERIALNO","=","vi1.SERIALNO"],
                ["vi1.LOCNCODE","=",DB::raw("'VI1'")],
            ])
            ->where([
                ["lbl02.LBLTYPE","=",1],
                ["mes01.TRXDATE",">=",$last_trx],
                ["mes01.TRXDATE","<",$dt],
                ["mes01.LOCNCODE","=","TEST-EL"],
                ["mes01.PRODLINE","=",$prodline],
                ["lbl02.MODCLASS","=","B"],
                [DB::raw("CASE WHEN vi1.SNOSTAT = 1 AND vi1.MODCLASS = '' THEN (SELECT MCLCODE FROM cls01 WHERE CUSTOMER = lbl02.CUSTOMER AND MODSTATUS = 0 ORDER BY MCLCODE DESC LIMIT 1) ELSE vi1.MODCLASS END"),"<>","B"],
            ])->count("mes01.SERIALNO");

        $el2_class_c = mesData::join("lbl02","mes01.SERIALNO","=","lbl02.SERIALNO")
            ->join("mes01 as vi1",[
                ["lbl02.SERIALNO","=","vi1.SERIALNO"],
                ["vi1.LOCNCODE","=",DB::raw("'VI1'")],
            ])
            ->where([
                ["lbl02.LBLTYPE","=",1],
                ["mes01.TRXDATE",">=",$last_trx],
                ["mes01.TRXDATE","<",$dt],
                ["mes01.LOCNCODE","=","TEST-EL"],
                ["mes01.PRODLINE","=",$prodline],
                ["lbl02.MODCLASS","=",($build == "GT" ? "C" : "")],
                ["vi1.MODCLASS","<>",($build == "GT" ? "C" : "")],
            ])->count("mes01.SERIALNO");

        $data['input_mod'] = $input_mod;
        $data['be_inspected'] = $input_mod;
        $data['be_defect'] = $be_class_b + $be_class_c;
        $data['be_class_b'] = $be_class_b;
        $data['be_class_c'] = $be_class_c;
        $data['el2_class_a'] = $el2_class_a;
        $data['el2_class_c'] = $el2_class_c;
        $data['el2_class_b'] = $el2_class_b;

        return Response::json($data);
    }
}
