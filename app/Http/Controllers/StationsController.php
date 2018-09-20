<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Station;
Use App\Machine;

Use DataTables;

class StationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('proddt.setup.station.list');
    }

    public function load()
    {
        $stations = Station::selectRaw("stations.id, stations.code, stations.descr, machines.descr as machine, machines.capacity")
                        ->leftJoin("machines","stations.machine_id","=","machines.id")
                        ->orderByRaw("code ASC");

        return Datatables::of($stations)->make(true);
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

        $data['code'] = $request->input('code');
        $data['descr'] = $request->input('descr');
        $data['machine_id'] = $request->input('machine_id');

        $data['modify'] = 0;
        $data['machines'] = Machine::all();
        return view('proddt.setup.station.form', $data);
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

        $data['code'] = $request->input('code');
        $data['descr'] = $request->input('descr');
        $data['machine_id'] = $request->input('machine_id');
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:proddt.stations',
                'descr' => 'required|max:50|unique:proddt.stations',
                'machine_id' => 'required',
            ]);

            Station::create($data);
            return redirect('proddt/setup/station')->with("success","Station [".$data["descr"]."] successfully added.");
        }

        $data['modify'] = 0;
        $data['machines'] = Machine::all();
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
        $data = [];

        $data['id'] = $id;
        $data['modify'] = 1;
        $data['machines'] = Machine::all();
                
        $station = Station::find($id);

        $data['code'] = $station->code;
        $data['descr'] = $station->descr;
        $data['machine_id'] = $station->machine_id;
                
        return view('proddt.setup.station.form', $data);
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

        $data['code'] = $request->input('code');
        $data['descr'] = $request->input('descr');
        $data['machine_id'] = $request->input('machine_id');

        // dd($request);
        if ($request->isMethod('PUT')) {
            $station = Station::find($id);
            
            $this->validate($request, [
                'code' => 'required|max:15|unique:proddt.stations,code,'.$station->id,
                'descr' => 'required|max:50|unique:proddt.stations,descr,'.$station->id,
                'machine_id' => 'required',
            ]);

            $station->code = $data['code'];
            $station->descr = $data['descr'];
            $station->machine_id = $data['machine_id'];
            
            $station->save();
            return redirect('proddt/setup/station')->with("success","Station [".$data["descr"]."] successfully updated.");
        }

        $data['modify'] = 1;
        $data['machines'] = Machine::all();
        return view('proddt.setup.station.form', $data);
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
