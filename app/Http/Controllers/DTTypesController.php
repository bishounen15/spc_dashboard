<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Machine;
use App\DTCategory;
use App\DTType;

use Validator;
use DataTables;
use Response;

class DTTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($machine_id)
    {
        //
        $data = [];

        $data['machine'] = Machine::find($machine_id);
        $data['categories'] = DTCategory::all();

        // dd($data['categories']);
        return view('proddt.setup.machine.types', $data);
    }

    public function load($machine_id, $category_id) {
        $downtime = DTType::selectRaw("id, downtime")
                        ->where([
                            ["machine_id",$machine_id],
                            ["category_id", $category_id],
                        ])
                        ->orderByRaw("id ASC");

        return Datatables::of($downtime)->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $data['machine_id'] = $request->input('machine_id');
        $data['category_id'] = $request->input('category_id');
        $data['downtime'] = $request->input('downtime');
        
        if ($request->isMethod('post')) {
            $validator = Validator::make($request->all(), [
                'machine_id' => 'required|integer',
                'category_id' => 'required|integer',
                'downtime' => 'required|unique:proddt.dt_types,downtime,NULL,id,machine_id,'.$request->input('machine_id').',category_id,'.$request->input('category_id'),
            ]);

            if ($validator->fails()) {
                // return Response::json($validator);
            } else {
                DTType::create($data);
            }

            return Response::json($validator->errors());
            // return redirect('proddt/setup/station')->with("success","Station [".$data["descr"]."] successfully added.");
        }

        // $data['modify'] = 0;
        // $data['machines'] = Machine::all();
        // return view('proddt.setup.station.form', $data);
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
    public function update(Request $request, $machine_id, $id)
    {
        //
        $data = [];

        $data['id'] = $id;
        $data['machine_id'] = $request->input('machine_id');
        $data['category_id'] = $request->input('category_id');
        $data['downtime'] = $request->input('downtime');

        // if ($request->isMethod('post')) {
            $dt = DTType::find($id);
            // return Response::json($data);
            $validator = Validator::make($request->all(), [
                'downtime' => 'required|unique:proddt.dt_types,downtime,'.$dt->id.',id,machine_id,'.$request->input('machine_id').',category_id,'.$request->input('category_id'),
            ]);

            if ($validator->fails()) {
                // return Response::json($validator);
            } else {
                $dt->downtime = $data['downtime'];
                $dt->save();
            }

            return Response::json($validator->errors());
            // return redirect('proddt/setup/station')->with("success","Station [".$data["descr"]."] successfully added.");
        // }
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
