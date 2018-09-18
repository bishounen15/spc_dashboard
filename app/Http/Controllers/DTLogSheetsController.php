<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTLogSheet;
use App\Station;
use App\DTType;

use DataTables;
Use Response;

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

    public function load()
    {
        $logs = DTLogSheet::selectRaw("log_sheets.id, log_sheets.date, log_sheets.shift, stations.descr as station, log_sheets.start, log_sheets.end, log_sheets.duration, dt_types.downtime as issue, categories.descr as category, log_sheets.remarks")
                        ->join("stations","log_sheets.station_id","=","stations.id")
                        ->join("dt_types","log_sheets.downtime_id","=","dt_types.id")
                        ->join("categories","dt_types.category_id","=","categories.id")
                        ->orderByRaw("log_sheets.date ASC, log_sheets.shift ASC, log_sheets.start ASC");

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
            $this->validate($request, [
                'date' => 'required',
                'shift' => 'required',
                'start' => 'required|date_format:H:i',
                'end' => 'required|date_format:H:i|after:start',
                'duration' => 'required|min:0.01',
                'station_id' => 'required',
                'downtime_id' => 'required',
                'remarks' => 'required',
            ]);

            DTLogSheet::create($data);
            return redirect('proddt/logsheet')->with("success","Log Entry successfully added.");
        }

        $data['modify'] = 0;
        $data['stations'] = Station::orderBy("descr","ASC")->get();
        return view('proddt.setup.station.form', $data);
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
