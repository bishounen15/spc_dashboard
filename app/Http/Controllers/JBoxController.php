<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\jboxDisWtQual;
class JBoxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::select('SELECT * FROM jbox_dis_wt_quals');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
          return view('backEnd.jBoxDispense')->with('disLogs',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // return view('backEnd.jBoxDisCreate');

        $posts = DB::select('SELECT * FROM jbox_dis_wt_quals ORDER BY ID DESC LIMIT 1');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
       return view('backEnd.jBoxDisCreate')->with('disLogs',$posts);
        
    
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
            'beadWt' =>'required|between:0,14.00',
          //  'snapTime' => 'required',
            'qualTime' => 'required'
        ]);
       
        $post = new jboxDisWtQual;
     //   $post->qualTransID = $request->input('transID');
        $post->shift = $request->input('shift');
        $post->date = $request->input('fixture_date');
        $post->beadWt = $request->input('beadWt');
        $post->qualTime = $request -> input('qualTime');
       // $post->materialPN = $request->input('materialPN');
      //  $post->remarks = $request->input('remarks');
        $post->jBox = $request->input('jBox');
        $post->sealant = $request->input('sealant');
        $post->target = $request->input('target');
        $post->cdaPressure = $request->input('cdaPressure');
        $post->mainCDASupply = $request->input('mainCDASup');
        $post->RAMCDA = $request->input('ramCDA');
        $post->downStream = $request->input('downStream');
        $post->qualRes= $request->input('result');
        $post->remarks = $request->input('remarks');

       // $post->crossSection = $request->input('crossSection');
        $post->save();

        return redirect('/JBox')->with('success','Record was successfully added!');
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
