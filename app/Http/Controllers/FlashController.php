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
        //
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
            'Date' => 'required',
            'Difference' => 'required',
            'CalSerial' => 'required',
            'Remarks' => 'required',
            'Target' => 'required',
            'Actual' => 'required',
        ]);

        //Create
        $flash = new Flash();
        $flash->Date = $request->input('Date');
        $flash->Difference = $request->input('Difference');
        $flash->CalSerial = $request->input('CalSerial');
        $flash->Remarks = $request->input('Remarks');
        $flash->Target = $request->input('Target');
        $flash->Actual = $request->input('Actual');
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
