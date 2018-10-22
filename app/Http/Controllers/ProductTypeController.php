<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductTypes;

use DataTables;
Use Response;

class ProductTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('yield.setup.product_type.list');
    }

    public function load()
    {
        $prod_types = ProductTypes::selectRaw("id, code, descr, CAST(target AS decimal(10,2)) AS target")
        ->orderByRaw("code ASC");

        return Datatables::of($prod_types)->make(true);
    }

    public function getTarget(Request $request) {
        $prod_type = ProductTypes::where("code",$request->input("build"))->first();
        return Response::json($prod_type);
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
        $data['target'] = $request->input('target');

        $data['modify'] = 0;
        return view('yield.setup.product_type.form', $data);
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
        $data['target'] = $request->input('target');
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:yield.product_types',
                'descr' => 'required|max:50|unique:yield.product_types',
                'target' => 'required|numeric',
            ]);

            ProductTypes::create($data);
            return redirect('yield/setup/product_types')->with("success","Product Type [".$data["descr"]."] successfully added.");
        }

        $data['modify'] = 0;
        return view('yield.setup.product_type.form', $data);
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
                
        $prod_type = ProductTypes::find($id);

        $data['code'] = $prod_type->code;
        $data['descr'] = $prod_type->descr;
        $data['target'] = number_format($prod_type->target,2);
                
        return view('yield.setup.product_type.form', $data);
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
        $data['target'] = $request->input('target');

        // dd($request);
        if ($request->isMethod('PUT')) {
            $prod_types = ProductTypes::find($id);
            
            $this->validate($request, [
                'code' => 'required|max:15|unique:yield.product_types,code,'.$prod_types->id,
                'descr' => 'required|max:50|unique:yield.product_types,descr,'.$prod_types->id,
                'target' => 'required|numeric',
            ]);

            $prod_types->code = $data['code'];
            $prod_types->descr = $data['descr'];
            $prod_types->target = $data['target'];
            
            $prod_types->save();
            return redirect('yield/setup/product_types')->with("success","Product Type [".$data["descr"]."] successfully updated.");
        }

        $data['modify'] = 0;
        return view('yield.setup.product_type.form', $data);
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
