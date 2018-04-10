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
        //
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
            'Laminator' => 'required',
            'Shift' => 'required',
            'Cell' => 'required',
            'Ribbon' => 'required',
            'Station' => 'required',
            'Side' => 'required',
            'CellNo' => 'required',
            'Site' => 'required',
            'Location' => 'required',
            'PeelTest' => 'required',
            'Criteria' => 'required',
            'Remarks' => 'required',
        ]);

        //Create
        $stringer = new Stringer();
        $stringer->Date = $request->input('Date');
        $stringer->Laminator = $request->input('Laminator');
        $stringer->Shift = $request->input('Shift');
        $stringer->Cell = $request->input('Cell');
        $stringer->Ribbon = $request->input('Ribbon');
        $stringer->Station = $request->input('Station');
        $stringer->Side = $request->input('Side');
        $stringer->CellNo = $request->input('CellNo');
        $stringer->Site = $request->input('Site');
        $stringer->Location = $request->input('Location');
        $stringer->PeelTest = $request->input('PeelTest');
        $stringer->Criteria = $request->input('Criteria');
        $stringer->Remarks = $request->input('Remarks');
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
