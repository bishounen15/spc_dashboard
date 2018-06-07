<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Flash;
use DB;

class FlashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::select('SELECT * FROM flashes'); 
        //$posts = Post::orderBy('created_at','desc')->paginate(2);
        return view('pages.ftd')  
                    ->with('alldata',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('posts.flash');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'ModuleID' => 'required',
            'InspTime' => 'required',
            'ISC' => 'required',
            'UOC' => 'required',
            'IMPP' => 'required',
            'UMPP' => 'required',
            'PMPP' => 'required',
            'ShuntResist' => 'required',
            'FF' => 'required',
            'BIN' => 'required',
        ]);

        //Create
        $flash = new Flash();
        $flash->ModuleID = $request->input('ModuleID');
        $flash->InspTime = $request->input('InspTime');
        $flash->ISC = $request->input('ISC');
        $flash->UOC = $request->input('UOC');
        $flash->IMPP = $request->input('IMPP');
        $flash->UMPP = $request->input('UMPP');
        $flash->PMPP = $request->input('PMPP');
        $flash->ShuntResist = $request->input('ShuntResist');
        $flash->FF = $request->input('FF');
        $flash->BIN = $request->input('BIN');
        $flash->save();

        return redirect('/flash/create')->with('success', 'Successfully Created');
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
