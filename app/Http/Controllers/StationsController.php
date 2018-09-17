<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Station;

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
        $stations = Station::selectRaw("id, code, descr, capacity")
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
        $data['capacity'] = $request->input('capacity');

        $data['modify'] = 0;
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
        $data['capacity'] = $request->input('capacity');
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:proddt.stations',
                'descr' => 'required|max:50|unique:proddt.stations',
                'capacity' => 'required|integer',
            ]);

            Station::create($data);
            return redirect('proddt/setup/station')->with("success","Station [".$data["descr"]."] successfully added.");
        }

        $data['modify'] = 0;
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
                
        $station = Station::find($id);

        $data['code'] = $station->code;
        $data['descr'] = $station->descr;
        $data['capacity'] = $station->capacity;
                
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
        $data['capacity'] = $request->input('capacity');

        // dd($request);
        if ($request->isMethod('PUT')) {
            $station = Station::find($id);
            
            $this->validate($request, [
                'code' => 'required|max:15|unique:proddt.stations,code,'.$station->id,
                'descr' => 'required|max:50|unique:proddt.stations,descr,'.$station->id,
                'capacity' => 'required|integer',
            ]);

            $station->code = $data['code'];
            $station->descr = $data['descr'];
            $station->capacity = $data['capacity'];
            
            $station->save();
            return redirect('proddt/setup/station')->with("success","Station [".$data["descr"]."] successfully updated.");
        }

        dd($request);

        $data['modify'] = 0;
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
