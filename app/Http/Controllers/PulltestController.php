<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pulltest;
use DB;

class PulltestController extends Controller
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
       
        return view ('posts.pulltest');
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
            'Recipe' => 'required',
            'Glass' => 'required',
            'ModuleID' => 'required',
            'EVA' => 'required',
            'Backsheet' => 'required',
            'Location' => 'required',
            'PTEG1' => 'required',
            'PTEG2' => 'required',
            'PTEG3' => 'required',
            'PTEG4' => 'required',
            'PTEG5' => 'required',
            'PTEG6' => 'required',
            'PTEG7' => 'required',
            'PTEG8' => 'required',
            'PTEG9' => 'required',
            'PTEG11' => 'required',
            'PTEG12' => 'required',
            'PTEG13' => 'required',
            'PTEG14' => 'required',
            'PTEG15' => 'required',
            'PTEGA' => 'required',
            'PTEB1' => 'required',
            'PTEB2' => 'required',
            'PTEB3' => 'required',
            'PTEB4' => 'required',
            'PTEB5' => 'required',
            'PTEB6' => 'required',
            'PTEB7' => 'required',
            'PTEB8' => 'required',
            'PTEB9' => 'required',
            'PTEB10' => 'required',
            'PTEB11' => 'required',
            'PTEB12' => 'required',
            'PTEB13' => 'required',
            'PTEB14' => 'required',
            'PTEB15' => 'required',
            'PTEBA' => 'required',
        ]);

        //Create
        $pulltest = new Pulltest();
        $pulltest->Date = $request->input('Date');
        $pulltest->Laminator = $request->input('Laminator');
        $pulltest->Shift = $request->input('Shift');
        $pulltest->Recipe = $request->input('Recipe');
        $pulltest->Glass = $request->input('Glass');
        $pulltest->ModuleID = $request->input('ModuleID');
        $pulltest->EVA = $request->input('EVA');
        $pulltest->Backsheet = $request->input('Backsheet');
        $pulltest->Location = $request->input('Location');
        $pulltest->PTEG1 = $request->input('PTEG1');
        $pulltest->PTEG2 = $request->input('PTEG2');
        $pulltest->PTEG3 = $request->input('PTEG3');
        $pulltest->PTEG4 = $request->input('PTEG4');
        $pulltest->PTEG5 = $request->input('PTEG5');
        $pulltest->PTEG6 = $request->input('PTEG6');
        $pulltest->PTEG7 = $request->input('PTEG7');
        $pulltest->PTEG8 = $request->input('PTEG8');
        $pulltest->PTEG9 = $request->input('PTEG9');
        $pulltest->PTEG10 = $request->input('PTEG10');
        $pulltest->PTEG11 = $request->input('PTEG11');
        $pulltest->PTEG12 = $request->input('PTEG12');
        $pulltest->PTEG13 = $request->input('PTEG13');
        $pulltest->PTEG14 = $request->input('PTEG14');
        $pulltest->PTEG15 = $request->input('PTEG15');
        $pulltest->PTEGA = $request->input('PTEGA');
        $pulltest->PTEB1 = $request->input('PTEB1');
        $pulltest->PTEB2 = $request->input('PTEB2');
        $pulltest->PTEB3 = $request->input('PTEB3');
        $pulltest->PTEB4 = $request->input('PTEB4');
        $pulltest->PTEB5 = $request->input('PTEB5');
        $pulltest->PTEB6 = $request->input('PTEB6');
        $pulltest->PTEB7 = $request->input('PTEB7');
        $pulltest->PTEB8 = $request->input('PTEB8');
        $pulltest->PTEB9 = $request->input('PTEB9');
        $pulltest->PTEB10 = $request->input('PTEB10');
        $pulltest->PTEB11 = $request->input('PTEB11');
        $pulltest->PTEB12 = $request->input('PTEB12');
        $pulltest->PTEB13 = $request->input('PTEB13');
        $pulltest->PTEB14 = $request->input('PTEB14');
        $pulltest->PTEB15 = $request->input('PTEB15');
        $pulltest->PTEBA = $request->input('PTEBA');
        $pulltest->save();
        return redirect('/pulltest/create')->with('success', 'Successfully Created');
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
