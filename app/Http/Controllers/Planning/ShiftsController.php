<?php

namespace App\Http\Controllers\Planning;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Planning\Shift;

use DataTables;
Use Response;

class ShiftsController extends Controller
{
    //
    public function index()
    {
        //
        return view('planning.setup.shift.list');
    }

    public function load()
    {
        $shifts = Shift::selectRaw("id, code, descr, start_time, end_time, CASE overday WHEN 1 THEN 'Yes' ELSE 'No' END AS overday")
        ->orderByRaw("code ASC");

        return Datatables::of($shifts)->make(true);
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
        $data['start_time'] = $request->input('start_time');
        $data['end_time'] = $request->input('end_time');
        $data['overday'] = $request->input('overday');
        $data['duration'] = $request->input('duration');

        $data['modify'] = 0;
        return view('planning.setup.shift.form', $data);
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
        $data['start_time'] = $request->input('start_time');
        $data['end_time'] = $request->input('end_time');
        $data['overday'] = $request->input('overday') == "Yes" ? 1 : 0;
        $data['duration'] = $request->input('duration');
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:planning.shifts',
                'descr' => 'required|max:50|unique:planning.shifts',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i',
            ]);

            Shift::create($data);
            return redirect('planning/setup/shift')->with("success","Shift [".$data["descr"]."] successfully added.");
        }

        $data['modify'] = 0;
        return view('shift.setup.shift.form', $data);
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
                
        $shift = Shift::find($id);

        $data['code'] = $shift->code;
        $data['descr'] = $shift->descr;
        $data['start_time'] = date('H:i',strtotime($shift->start_time));
        $data['end_time'] = date('H:i',strtotime($shift->end_time));
        $data['overday'] = $shift->overday == 1 ? "Yes" : "No";
        $data['duration'] = number_format($shift->duration,2);
                
        return view('planning.setup.shift.form', $data);
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
        // dd($request);
        $data = [];

        $data['code'] = $request->input('code');
        $data['descr'] = $request->input('descr');
        $data['start_time'] = $request->input('start_time');
        $data['end_time'] = $request->input('end_time');
        $data['overday'] = $request->input('overday') == "Yes" ? 1 : 0;
        $data['duration'] = $request->input('duration');

        // dd($request);
        if ($request->isMethod('PUT')) {
            $shift = Shift::find($id);
            
            $this->validate($request, [
                'code' => 'required|max:15|unique:planning.shifts,code,'.$shift->id,
                'descr' => 'required|max:50|unique:planning.shifts,descr,'.$shift->id,
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i',
            ]);

            $shift->code = $data['code'];
            $shift->descr = $data['descr'];
            $shift->start_time = $data['start_time'];
            $shift->end_time = $data['end_time'];
            $shift->overday = $data['overday'];
            $shift->duration = $data['duration'];
            
            $shift->save();
            return redirect('planning/setup/shift')->with("success","Shift [".$data["descr"]."] successfully updated.");
        }

        $data['modify'] = 1;
        return view('shift.setup.shift.form', $data);
    }
}
