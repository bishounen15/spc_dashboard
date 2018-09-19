<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTLogSheet;
use App\Station;
use App\DTCategory;
use App\DTType;

use Validator;
use DataTables;
use Response;

class DTLogSheetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('proddt.logsheet.list');
    }

    public function dashboard()
    {
        //
        $data = [];

        $data['stations'] = Station::orderBy("descr","ASC")->get();
        $data['categories'] = DTCategory::all();

        return view('proddt.logsheet.dashboard', $data);
    }

    public function load()
    {
        $logs = DTLogSheet::selectRaw("log_sheets.id, log_sheets.date, log_sheets.shift, stations.descr as station, log_sheets.start, log_sheets.end, log_sheets.duration, dt_types.downtime as issue, categories.descr as category, log_sheets.remarks")
                        ->join("stations","log_sheets.station_id","=","stations.id")
                        ->join("dt_types","log_sheets.downtime_id","=","dt_types.id")
                        ->join("categories","dt_types.category_id","=","categories.id")
                        ->orderByRaw("log_sheets.date DESC, log_sheets.shift DESC, DATE_ADD(log_sheets.date, INTERVAL CASE WHEN log_sheets.start < '06:00' THEN 1 ELSE 0 END DAY) DESC, log_sheets.start DESC");

        return Datatables::of($logs)->make(true);
    }

    public function dashdata($date, $shift = '-', $station_id = 0)
    {
        $cond = [];

        array_push($cond,["log_sheets.date",$date]);

        if ($shift != "-") { array_push($cond,["log_sheets.shift",$shift]); }
        if ($station_id != 0) { array_push($cond,["log_sheets.station_id",$station_id]); }

        $logs = DTLogSheet::selectRaw("log_sheets.id, log_sheets.date, log_sheets.shift, stations.descr as station, log_sheets.start, log_sheets.end, ROUND(log_sheets.duration,2) AS duration, dt_types.downtime as issue, categories.code as code, categories.descr as category, log_sheets.remarks, machines.descr as machine, machines.capacity")
                        ->join("stations","log_sheets.station_id","=","stations.id")
                        ->join("machines","stations.machine_id","=","machines.id")
                        ->join("dt_types","log_sheets.downtime_id","=","dt_types.id")
                        ->join("categories","dt_types.category_id","=","categories.id")
                        ->where($cond)
                        ->orderByRaw("log_sheets.date ASC, log_sheets.shift ASC, DATE_ADD(log_sheets.date, INTERVAL CASE WHEN log_sheets.start < '06:00' THEN 1 ELSE 0 END DAY) ASC, log_sheets.start ASC");

        return Datatables::of($logs)->make(true);
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

        $data['date'] = date("Y-m-d");
        $data['shift'] = $request->input('shift');
        $data['start'] = $request->input('start');
        $data['end'] = $request->input('end');
        $data['duration'] = $request->input('duration');
        $data['station_id'] = $request->input('station_id');
        $data['category_id'] = $request->input('category_id');
        $data['downtime_id'] = $request->input('downtime_id');
        $data['remarks'] = $request->input('remarks');
        
        $data['modify'] = 0;
        $data['stations'] = Station::orderBy("descr","ASC")->get();
        $data['categories'] = [];
        $data['issues'] = [];
        
        return view('proddt.logsheet.form', $data);
    }

    public function listCategories(Request $request) {
        $categories = Station::find($request->input('station_id'))->machine->categories();
        return Response::json($categories);
    }

    public function listIssues(Request $request) {
        $types = Station::find($request->input('station_id'))->machine->issues
                            ->where("category_id",$request->input('category_id'));
        return Response::json($types);
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

        $data['date'] = $request->input('date');
        $data['shift'] = $request->input('shift');
        $data['start'] = $request->input('start');
        $data['end'] = $request->input('end');
        $data['duration'] = $request->input('duration');
        $data['station_id'] = $request->input('station_id');
        $data['category_id'] = $request->input('category_id');
        $data['downtime_id'] = $request->input('downtime_id');
        $data['remarks'] = $request->input('remarks');

        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'date' => 'required',
                'shift' => 'required',
                'start' => 'required|date_format:H:i',
                'end' => 'required|date_format:H:i|after:start',
                'duration' => 'required|min:0.01',
                'station_id' => 'required',
                'downtime_id' => 'required',
                'remarks' => 'required',
            ]);
            
            if ($validator->fails()) {
                $data['modify'] = 0;
                $data['stations'] = Station::orderBy("descr","ASC")->get();
                $categories = $request->input('station_id') != null ? Station::find($request->input('station_id'))->machine->categories() : [];
                $data['categories'] = $categories;
                $issues = $request->input('station_id') != null || $request->input('station_id') != null ? Station::find($request->input('station_id'))->machine->issues->where("category_id",$request->input('category_id')) : [];
                $data['issues'] = $issues;
                $data['errors'] = $validator->errors();

                return view('proddt.logsheet.form', $data);
            } else {
                DTLogSheet::create($data);
                return redirect('proddt/logsheet')->with("success","Log Entry successfully added.");
            }
        }
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

        $log = DTLogSheet::find($id);

        $data['id'] = $log->id;
        $data['date'] = $log->date;
        $data['shift'] = $log->shift;
        $data['start'] = date('H:i',strtotime($log->start));
        $data['end'] = date('H:i',strtotime($log->end));
        $data['duration'] = $log->duration;
        $data['station_id'] = $log->station_id;
        $data['category_id'] = $log->issue->category_id;
        $data['downtime_id'] = $log->downtime_id;
        $data['remarks'] = $log->remarks;

        $data['modify'] = 1;
        $data['stations'] = Station::orderBy("descr","ASC")->get();
        $categories = Station::find($data['station_id'])->machine->categories();
        $data['categories'] = $categories;
        $issues = Station::find($data['station_id'])->machine->issues->where("category_id",$data['category_id']);
        $data['issues'] = $issues;

        return view('proddt.logsheet.form', $data);
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

        $data['date'] = $request->input('date');
        $data['shift'] = $request->input('shift');
        $data['start'] = $request->input('start');
        $data['end'] = $request->input('end');
        $data['duration'] = $request->input('duration');
        $data['station_id'] = $request->input('station_id');
        $data['category_id'] = $request->input('category_id');
        $data['downtime_id'] = $request->input('downtime_id');
        $data['remarks'] = $request->input('remarks');

        if ($request->isMethod('put')) {
            $validator = Validator::make($request->all(), [
                'date' => 'required',
                'shift' => 'required',
                'start' => 'required|date_format:H:i',
                'end' => 'required|date_format:H:i|after:start',
                'duration' => 'required|numeric|min:0.01',
                'station_id' => 'required',
                'downtime_id' => 'required',
                'remarks' => 'required',
            ]);
            
            if ($validator->fails()) {
                $data['id'] = $id;
                $data['modify'] = 1;
                $data['stations'] = Station::orderBy("descr","ASC")->get();
                $categories = $request->input('station_id') != null ? Station::find($request->input('station_id'))->machine->categories() : [];
                $data['categories'] = $categories;
                $issues = $request->input('station_id') != null || $request->input('station_id') != null ? Station::find($request->input('station_id'))->machine->issues->where("category_id",$request->input('category_id')) : [];
                $data['issues'] = $issues;
                $data['errors'] = $validator->errors();

                return view('proddt.logsheet.form', $data);
            } else {
                $log = DTLogSheet::find($id);

                $log->date = $data['date'];
                $log->shift = $data['shift'];
                $log->start = $data['start'];
                $log->end = $data['end'];
                $log->duration = $data['duration'];
                $log->station_id = $data['station_id'];
                $log->downtime_id = $data['downtime_id'];
                $log->remarks = $data['remarks'];

                $log->save();
                return redirect('proddt/logsheet')->with("success","Log Entry successfully updated.");
            }
        }
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
