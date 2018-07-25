<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
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
        $posts = DB::select('SELECT * FROM frame_sq_bws');                                        
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
       // return view('backEnd.frameSqBwCreate');

        $posts = DB::select('SELECT * FROM frame_sq_bws ORDER BY ID DESC LIMIT 1');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
       return view('backEnd.frameSqBwCreate')->with('frameSBLogs',$posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[ 
          'serialNoTxt' => 'required',
          'qualTime' => 'required',
          'L1txt' => 'required',
          'L2txt' => 'required',
          'L3txt' => 'required',
          'S1txt' => 'required',
          'S2txt' => 'required',
          'S3txt' => 'required',
           'D1txt' => 'required',
           'D2txt' => 'required' 
             ]); 

        $post = new frameSqBw;
        $post->qualTransID = $request->input('transID');
        $post->shift = $request->input('shift');
        $post->date = $request->input('fixture_date');
        $post->moduleID = $request->input('serialNoTxt');
        $post->qualTime = $request->input('qualTime');
        $post->cellCount = $request->input('cellType');
            $post->L1= $request ->input('L1txt');
            $post->L2= $request ->input('L2txt');
            $post->L3= $request ->input('L3txt');
            $post->S1= $request ->input('S1txt');
            $post->S2= $request ->input('S2txt');
            $post->S3= $request ->input('S3txt');
            $post->D1= $request ->input('D1txt');
            $post->D2= $request ->input('D2txt');
            $post->LDiff= $request ->input('LDiff');
            $post->SDiff= $request ->input('SDiff');
            $post->qualRes= $request ->input('qualRes');
            $post->target= $request ->input('target');
            $post->DDiff= $request ->input('DDiff');
            $post->remarks= $request ->input('remarkstxt');
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
