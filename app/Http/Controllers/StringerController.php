<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stringer;
use DB;

class StringerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::select('SELECT * FROM stringers'); 
        //$posts = Post::orderBy('created_at','desc')->paginate(2);
        return view('pages.stringerdata')  
                    ->with('alldata',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('posts.Stringer');
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
            'Date' => 'required',
            'Stringer' => 'required',
            'Shift' => 'required',
            'Cell' => 'required',
            'Ribbon' => 'required',
            'Side' => 'required',
            'CellNo' => 'required',
            'Location' => 'required',
            'PeelTest' => 'required',
            'Criteria' => 'required',
            'Remarks' => 'required',
            'Site1' => 'required',
            'Site2' => 'required',
            'Site3' => 'required',
            'Site4' => 'required',
            'Site5' => 'required',
            'Site6' => 'required',
            'Site7' => 'required',
            'Site8' => 'required',
            'Site9' => 'required',
            'Site10' => 'required',
            'Site11' => 'required',
            'Site12' => 'required',
            'Site13' => 'required',
            'Site14' => 'required',
            'Site15' => 'required',
            'Site16' => 'required',
        ]);

        //Create
        $stringer = new Stringer();
        $stringer->Date = $request->input('Date');
        $stringer->Stringer = $request->input('Stringer');
        $stringer->Shift = $request->input('Shift');
        $stringer->Cell = $request->input('Cell');
        $stringer->Ribbon = $request->input('Ribbon');
        $stringer->Side = $request->input('Side');
        $stringer->CellNo = $request->input('CellNo');
        $stringer->Location = $request->input('Location');
        $stringer->PeelTest = $request->input('PeelTest');
        $stringer->Criteria = $request->input('Criteria');
        $stringer->Remarks = $request->input('Remarks');
        $stringer->Site1 = $request->input('Site1');
        $stringer->Site2 = $request->input('Site2');
        $stringer->Site3 = $request->input('Site3');
        $stringer->Site4 = $request->input('Site4');
        $stringer->Site5 = $request->input('Site5');
        $stringer->Site6 = $request->input('Site6');
        $stringer->Site7 = $request->input('Site7');
        $stringer->Site8 = $request->input('Site8');
        $stringer->Site9 = $request->input('Site9');
        $stringer->Site10 = $request->input('Site10');
        $stringer->Site11 = $request->input('Site11');
        $stringer->Site12 = $request->input('Site12');
        $stringer->Site13 = $request->input('Site13');
        $stringer->Site14 = $request->input('Site14');
        $stringer->Site15 = $request->input('Site15');
        $stringer->Site16 = $request->input('Site16');
        $stringer->save();
        return redirect('/stringer/create')->with('success', 'Successfully Created');
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
