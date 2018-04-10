<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Laytec;
use DB;

class LaytecController extends Controller
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
        return view ('posts.laytec');
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
            'LXM' => 'required',
            'UCL' => 'required',
            'LCL' => 'required',
            'AVE' => 'required',
            'Target' => 'required',
            'CL' => 'required',
            'USL' => 'required',
            'LSL' => 'required',
            'Sgmaplus1' => 'required',
            'Sgmaplus2' => 'required',
            'Sgmamin1' => 'required',
            'Sgmamin2' => 'required',

            ]);

            //Create
        $laytec = new Laytec();
        $laytec->Date = $request->input('Date');
        $laytec->Laminator = $request->input('Laminator');
        $laytec->Shift = $request->input('Shift');
        $laytec->LXM = $request->input('LXM');
        $laytec->UCL = $request->input('UCL');
        $laytec->LCL = $request->input('LCL');
        $laytec->AVE = $request->input('AVE');
        $laytec->Target = $request->input('Target');
        $laytec->CL = $request->input('CL');
        $laytec->USL = $request->input('USL');
        $laytec->LSL = $request->input('LSL');
        $laytec->Sgmaplus1 = $request->input('Sgmaplus1');
        $laytec->Sgmaplus2 = $request->input('Sgmaplus2');
        $laytec->Sgmamin1 = $request->input('Sgmamin1');
        $laytec->Sgmamin2 = $request->input('Sgmamin2');
        $laytec->save();

        return redirect('/laytec/create')->with('success', 'Successfully Created');
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
