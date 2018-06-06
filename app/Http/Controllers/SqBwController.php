<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\frameSqBw;

class SqBwController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = frameSqBw::get(); //DB::select('SELECT * FROM frame_sq_bws');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
          return view('backEnd.frameSqBw')->with('frameSBLogs',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.frameSqBwCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new frameSqBw;
        $post->qualTransID = $request->input('transID');
        $post->shift = $request->input('shift');
        $post->date = $request->input('fixture_date');
        $post->moduleID = $request->input('serialNo');
            $post->L1= $request ->input('L1');
            $post->L2= $request ->input('L2');
            $post->L3= $request ->input('L3');
            $post->S1= $request ->input('S1');
            $post->S2= $request ->input('S2');
            $post->S3= $request ->input('S3');
            $post->D1= $request ->input('D1');
            $post->D2= $request ->input('D2');
            $post->LDiff= $request ->input('LDiff');
            $post->SDiff= $request ->input('SDiff');
            $post->DDiff= $request ->input('DDiff');
            $post->remarks= $request ->input('remarks');
       // $post->crossSection = $request->input('crossSection');
        $post->save();

        return redirect('/Framming')->with('success','Record was successfully added!');
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
