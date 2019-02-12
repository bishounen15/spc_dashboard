<?php

namespace App\Http\Controllers\Planning;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Planning\ProductionSchedule;
use App\Models\Planning\ProductionScheduleProduct;
use App\Models\Planning\ProductionScheduleShift;
use App\Models\Planning\Shift;

use App\Models\WebPortal\ProductionLine;
use App\Models\WebPortal\ProductType;

use DataTables;

class ProductionSchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = [];
        $data['lines'] = ProductionLine::all();
        return view("planning.schedule.list",$data);
    }

    public function load()
    {
        $lines = ProductionLine::all();
        $prod_lines = "";

        foreach($lines as $line) {
            $prod_lines .= ", SUM(CASE production_schedule_products.production_line WHEN ".$line->LINCODE." THEN production_schedule_products.qty ELSE 0 END) AS line_".$line->LINCODE;
        }

        $scheds = ProductionSchedule::selectRaw("production_schedules.id, production_schedules.production_date, production_schedules.work_week, production_schedules.weekday, SUM(production_schedule_products.qty) AS qty".$prod_lines.", production_schedules.activity, production_schedules.cells as cell, production_schedules.backsheets as backsheet, production_schedules.shifts")
                        ->leftJoin("production_schedule_products","production_schedules.id","production_schedule_products.schedule_id")
                        ->groupBy("production_schedules.id","production_schedules.production_date", "production_schedules.work_week", "production_schedules.weekday", "production_schedules.activity", "production_schedules.cells", "production_schedules.backsheets", "production_schedules.shifts")
                        ->orderByRaw("production_schedules.production_date ASC");

        return Datatables::of($scheds)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $data = [];

        $data['production_date'] = $request->input('production_date');
        $data['work_week'] = $request->input('work_week');
        $data['weekday'] = $request->input('weekday');
        $data['shifts'] = Shift::all();
        $data['lines'] = ProductionLine::all();
        $data['types'] = ProductType::where("ACTIVE",1)->get();
        $data['products'] = ProductionScheduleProduct::find(-1);
        $data['selected_sched'] = 0;

        // dd($data['products']);
                
        $data['modify'] = 0;
        return view('planning.schedule.form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $data = [];

        $data['production_date'] = $request->input('production_date');
        $data['work_week'] = $request->input('work_week');
        $data['weekday'] = $request->input('weekday');
        
        $shifts = "";

        if (!empty($request->input('selected_shifts'))) {
            foreach($request->input('selected_shifts') as $shift_id) {
                $shift = Shift::find($shift_id)->descr;
                $shifts .= ($shifts != "" ? "," : "") . $shift;
            }

            $data['shifts'] = $shifts;
        } else {
            $data['shifts'] = "Restday";
        }

        $activity = "";
        $cell = "";
        $backsheet = "";

        if (!empty($request->input('product-type'))) {
            $product_types = $request->input('product-type');

            foreach( $product_types as $key => $n ) {
                if ($n <> "") {
                    $activity .= ($activity != "" ? " / " : "") . $n;
                }
            }

            if (!empty($request->input('cell'))) {
                $cells = $request->input('cell');
                foreach( $cells as $key => $n ) {
                    if ($n <> "") {
                        if (strpos($cell, $n) === false) {
                            $cell .= ($cell != "" ? " / " : "") . $n;
                        }
                    }
                }
            }

            if (!empty($request->input('backsheet'))) {
                $backsheets = $request->input('backsheet');
                foreach( $backsheets as $key => $n ) {
                    if ($n <> "") {
                        if (strpos($backsheet, $n) === false) {
                            $backsheet .= ($backsheet != "" ? " / " : "") . $n;
                        }
                    }
                }
            }
        }

        $data['activity'] = $activity;
        $data['cells'] = $cell;
        $data['backsheets'] = $backsheet;

        if ($request->isMethod('post')) {
            $this->validate($request, [
                'production_date' => 'required|date|unique:planning.production_schedules',
            ]);

            ProductionSchedule::create($data);

            if (!empty($request->input('selected_shifts'))) {
                $sched_id = ProductionSchedule::where("production_date",$data["production_date"])->first()->id;
                foreach($request->input('selected_shifts') as $shift_id) {
                    ProductionScheduleShift::create([
                        "schedule_id" => $sched_id,
                        "shift_id" => $shift_id,
                    ]);
                }

                if (!empty($request->input('product-type'))) {
                    $product_types = $request->input('product-type');
                    $cells = $request->input('cell');
                    $backsheets = $request->input('backsheet');
                    $lines = ProductionLine::all();
    
                    foreach( $product_types as $key => $n ) {
                        if ($n <> "") {
                            foreach($lines as $line) {
                                if (!empty($request->input("line-".$line->LINCODE)[$key]) && $request->input("line-".$line->LINCODE)[$key] > 0) {
                                    ProductionScheduleProduct::create([
                                        "schedule_id" => $sched_id,
                                        "model_name" => $n,
                                        "production_line" => $line->LINCODE,
                                        "qty" => $request->input("line-".$line->LINCODE)[$key],
                                        "cell" => $cells[$key],
                                        "backsheet" => $backsheets[$key],
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            return redirect('planning/schedule')->with("success","Schedule for [".$data["production_date"]."] successfully added.");
        }

        $data['modify'] = 0;
        return view('planning.schedule.form', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = [];

        $data['id'] = $id;
        $data['modify'] = 1;
                
        $sched = ProductionSchedule::find($id);
        $lines = ProductionLine::all();

        $data['production_date'] = $sched->production_date;
        $data['work_week'] = $sched->work_week;
        $data['weekday'] = $sched->weekday;
        $data['sched'] = $sched;
        $data['shifts'] = Shift::all();
        $data['lines'] = $lines;
        $data['types'] = ProductType::where("ACTIVE",1)->get();

        $lineqry = "";
        foreach($lines as $line) {
            $lineqry .=  ", sum(case production_line when ".$line->LINCODE." then  qty else 0 end) as line_".$line->LINCODE;
        }

        $products = ProductionScheduleProduct::selectRaw("model_name".$lineqry.", cell, backsheet")->where("schedule_id",$id)->groupBy("model_name","cell","backsheet")->get();

        $data['products'] = $products;

        $selected_sched = ProductionScheduleShift::where("schedule_id",$id)->count();
        $data['selected_sched'] = $selected_sched;

        // dd($data['products']);
                
        return view('planning.schedule.form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data = [];

        $data['production_date'] = $request->input('production_date');
        $data['work_week'] = $request->input('work_week');
        $data['weekday'] = $request->input('weekday');
        $data['activity'] = "";

        $shifts = "";

        if (!empty($request->input('selected_shifts'))) {
            foreach($request->input('selected_shifts') as $shift_id) {
                $shift = Shift::find($shift_id)->descr;
                $shifts .= ($shifts != "" ? "," : "") . $shift;
            }

            $data['shifts'] = $shifts;
        } else {
            $data['shifts'] = "Restday";
        }
        
        $activity = "";
        
        if (!empty($request->input('product-type'))) {
            $product_types = $request->input('product-type');
            foreach( $product_types as $key => $n ) {
                if ($n <> "") {
                    $activity .= ($activity != "" ? " / " : "") . $n;
                }
            }
        }

        $data['activity'] = $activity;

        $cell = "";
        
        if (!empty($request->input('cell'))) {
            $cells = $request->input('cell');
            foreach( $cells as $key => $n ) {
                if ($n <> "") {
                    if (strpos($cell, $n) === false) {
                        $cell .= ($cell != "" ? " / " : "") . $n;
                    }
                }
            }
        }

        $data['cells'] = $cell;

        $backsheet = "";
        
        if (!empty($request->input('backsheet'))) {
            $backsheets = $request->input('backsheet');
            foreach( $backsheets as $key => $n ) {
                if ($n <> "") {
                    if (strpos($backsheet, $n) === false) {
                        $backsheet .= ($backsheet != "" ? " / " : "") . $n;
                    }
                }
            }
        }

        $data['backsheets'] = $backsheet;

        // dd($request);
        if ($request->isMethod('PUT')) {
            $sched = ProductionSchedule::find($id);
            
            $this->validate($request, [
                'production_date' => 'required|date|unique:planning.production_schedules,production_date,'.$sched->id,
            ]);

            $sched->production_date = $data['production_date'];
            $sched->work_week = $data['work_week'];
            $sched->weekday = $data['weekday'];
            $sched->shifts = $data['shifts'];
            $sched->activity = $data['activity'];
            $sched->cells = $data['cells'];
            $sched->backsheets = $data['backsheets'];
            
            $sched->save();

            ProductionScheduleShift::where("schedule_id",$id)->delete();
            if (!empty($request->input('selected_shifts'))) {
                foreach($request->input('selected_shifts') as $shift_id) {
                    ProductionScheduleShift::create([
                        "schedule_id" => $id,
                        "shift_id" => $shift_id,
                    ]);
                }

                ProductionScheduleProduct::where("schedule_id",$id)->delete();
                if (!empty($request->input('product-type'))) {
                    $product_types = $request->input('product-type');
                    $cells = $request->input('cell');
                    $backsheets = $request->input('backsheet');
                    $lines = ProductionLine::all();

                    foreach( $product_types as $key => $n ) {
                        if ($n <> "") {
                            foreach($lines as $line) {
                                if (!empty($request->input("line-".$line->LINCODE)[$key]) && $request->input("line-".$line->LINCODE)[$key] > 0) {
                                    ProductionScheduleProduct::create([
                                        "schedule_id" => $id,
                                        "model_name" => $n,
                                        "production_line" => $line->LINCODE,
                                        "qty" => $request->input("line-".$line->LINCODE)[$key],
                                        "cell" => $cells[$key],
                                        "backsheet" => $backsheets[$key],
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            return redirect('planning/schedule')->with("success","Production Date [".$data["production_date"]."] successfully updated.");
        }

        $data['modify'] = 1;
        return view('planning.schedule.form', $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
