<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\DTCategory;

Use DataTables;

class DTCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('proddt.setup.category.list');
    }

    public function load()
    {
        $categories = DTCategory::selectRaw("id, code, descr, color_scheme")
        ->orderByRaw("code ASC");

        return Datatables::of($categories)->make(true);
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
        $data['color_scheme'] = $request->input('color_scheme');

        $data['modify'] = 0;
        return view('proddt.setup.category.form', $data);
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
        $data['color_scheme'] = $request->input('color_scheme');
        
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'code' => 'required|max:15|unique:proddt.categories',
                'descr' => 'required|max:50|unique:proddt.categories',
                'color_scheme' => 'required|max:15|unique:proddt.categories',
            ]);

            DTCategory::create($data);
            return redirect('proddt/setup/category')->with("success","Category [".$data["descr"]."] successfully added.");
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
                
        $category = DTCategory::find($id);

        $data['code'] = $category->code;
        $data['descr'] = $category->descr;
        $data['color_scheme'] = $category->color_scheme;
                
        return view('proddt.setup.category.form', $data);
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
        $data['color_scheme'] = $request->input('color_scheme');

        // dd($request);
        if ($request->isMethod('PUT')) {
            $category = DTCategory::find($id);
            
            $this->validate($request, [
                'code' => 'required|max:15|unique:proddt.categories,code,'.$category->id,
                'descr' => 'required|max:50|unique:proddt.categories,descr,'.$category->id,
                'color_scheme' => 'required|max:15|unique:proddt.categories,color_scheme,'.$category->id,
            ]);

            $category->code = $data['code'];
            $category->descr = $data['descr'];
            $category->color_scheme = $data['color_scheme'];
            
            $category->save();
            return redirect('proddt/setup/category')->with("success","Category [".$data["descr"]."] successfully updated.");
        }

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
