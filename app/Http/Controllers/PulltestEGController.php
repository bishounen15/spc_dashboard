<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pulltesteg;
use DB;

class PulltestEGController extends Controller
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
        return view ('posts.pulltestEG');
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
            'PeelStrength' => 'required',
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
        $pulltesteg = new Pulltesteg();
        $pulltesteg->Date = $request->input('Date');
        $pulltesteg->Laminator = $request->input('Laminator');
        $pulltesteg->PullTest = $request->input('PullTest');
        $pulltesteg->PeelStrength = $request->input('PeelStrength');
        $pulltesteg->UCL = $request->input('UCL');
        $pulltesteg->LCL = $request->input('LCL');
        $pulltesteg->AVE = $request->input('AVE');
        $pulltesteg->Target = $request->input('Target');
        $pulltesteg->CL = $request->input('CL');
        $pulltesteg->USL = $request->input('USL');
        $pulltesteg->LSL = $request->input('LSL');
        $pulltesteg->Sgmaplus1 = $request->input('Sgmaplus1');
        $pulltesteg->Sgmaplus2 = $request->input('Sgmaplus2');
        $pulltesteg->Sgmamin1 = $request->input('Sgmamin1');
        $pulltesteg->Sgmamin2 = $request->input('Sgmamin2');
        $pulltesteg->save();

        return redirect('pulltestEG/create')->with('success', 'Successfully Created');
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
