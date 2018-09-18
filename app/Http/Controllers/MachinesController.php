<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Machine;

Use DataTables;

class MachinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('proddt.setup.machine.list');
    }

    public function load()
    {
        $machines = Machine::selectRaw("id, code, descr, capacity")
        ->orderByRaw("code ASC");

        return Datatables::of($machines)->make(true);
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
        return view('proddt.setup.machine.form', $data);
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

            Machine::create($data);
            return redirect('proddt/setup/machine')->with("success","Machine [".$data["descr"]."] successfully added.");
        }

        $data['modify'] = 0;
        return view('proddt.setup.machine.form', $data);
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
                
        $machine = Machine::find($id);

        $data['code'] = $machine->code;
        $data['descr'] = $machine->descr;
        $data['capacity'] = $machine->capacity;
                
        return view('proddt.setup.machine.form', $data);
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
            $machine = Machine::find($id);
            
            $this->validate($request, [
                'code' => 'required|max:15|unique:proddt.stations,code,'.$machine->id,
                'descr' => 'required|max:50|unique:proddt.stations,descr,'.$machine->id,
                'capacity' => 'required|integer',
            ]);

            $machine->code = $data['code'];
            $machine->descr = $data['descr'];
            $machine->capacity = $data['capacity'];
            
            $machine->save();
            return redirect('proddt/setup/machine')->with("success","Machine [".$data["descr"]."] successfully updated.");
        }

        $data['modify'] = 0;
        return view('proddt.setup.machine.form', $data);
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
