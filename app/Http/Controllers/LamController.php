<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lam;
use DB;

class LamController extends Controller
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
        return view ('posts.Lam');
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
            'LXM1' => 'required',
            'LXM2' => 'required',
            'LXM3' => 'required',
            'LXM4' => 'required',
            'LXM5' => 'required',
            'LXM6' => 'required',
            'LXM7' => 'required',
            'LXM8' => 'required',
            'LXM9' => 'required',
            'LXM10' => 'required',
            'LXM11' => 'required',
            'LXM12' => 'required',
            'LXM13' => 'required',
            'LXM14' => 'required',
            'LXM15' => 'required',
            'LXM16' => 'required',
            'LXMA' => 'required',
            'RelGel1' => 'required',
            'RelGel2' => 'required',
            'RelGel3' => 'required',
            'RelGel4' => 'required',
            'RelGel5' => 'required',
            'RelGel6' => 'required',
            'RelGel7' => 'required',
            'RelGel8' => 'required',
            'RelGel9' => 'required',
            'RelGel10' => 'required',
            'RelGel11' => 'required',
            'RelGel12' => 'required',
            'RelGel13' => 'required',
            'RelGel14' => 'required',
            'RelGel15' => 'required',
            'RelGel16' => 'required',
            'RelGelA' => 'required',
        ]);

        //Create
        $lam = new Lam();
        $lam->Date = $request->input('Date');
        $lam->Laminator = $request->input('Laminator');
        $lam->Shift = $request->input('Shift');
        $lam->Recipe = $request->input('Recipe');
        $lam->Glass = $request->input('Glass');
        $lam->ModuleID = $request->input('ModuleID');
        $lam->EVA = $request->input('EVA');
        $lam->Backsheet = $request->input('Backsheet');
        $lam->Location = $request->input('Location');
        $lam->LXM1 = $request->input('LXM1');
        $lam->LXM2 = $request->input('LXM2');
        $lam->LXM3 = $request->input('LXM3');
        $lam->LXM4 = $request->input('LXM4');
        $lam->LXM5 = $request->input('LXM5');
        $lam->LXM6 = $request->input('LXM6');
        $lam->LXM7 = $request->input('LXM7');
        $lam->LXM8 = $request->input('LXM8');
        $lam->LXM9 = $request->input('LXM9');
        $lam->LXM10 = $request->input('LXM10');
        $lam->LXM11 = $request->input('LXM11');
        $lam->LXM12 = $request->input('LXM12');
        $lam->LXM13 = $request->input('LXM13');
        $lam->LXM14 = $request->input('LXM14');
        $lam->LXM15 = $request->input('LXM15');
        $lam->LXM16 = $request->input('LXM16');
        $lam->LXMA = $request->input('LXMA');
        $lam->RelGel1 = $request->input('RelGel1');
        $lam->RelGel2 = $request->input('RelGel2');
        $lam->RelGel3 = $request->input('RelGel3');
        $lam->RelGel4 = $request->input('RelGel4');
        $lam->RelGel5 = $request->input('RelGel5');
        $lam->RelGel6 = $request->input('RelGel6');
        $lam->RelGel7 = $request->input('RelGel7');
        $lam->RelGel8 = $request->input('RelGel8');
        $lam->RelGel9 = $request->input('RelGel9');
        $lam->RelGel10 = $request->input('RelGel10');
        $lam->RelGel11 = $request->input('RelGel11');
        $lam->RelGel12 = $request->input('RelGel12');
        $lam->RelGel13 = $request->input('RelGel13');
        $lam->RelGel14 = $request->input('RelGel14');
        $lam->RelGel15 = $request->input('RelGel15');
        $lam->RelGel16 = $request->input('RelGel16');
        $lam->RelGelA = $request->input('RelGelA');
        $lam->save();

        return redirect('/lam/create')->with('success', 'Successfully Created');
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
