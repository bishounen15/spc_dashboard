<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\frameQual;


class FrameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = frameQual::orderBy("id","desc")->get();//DB::select('SELECT * FROM frame_quals ORDER BY ID DESC');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
        return view('backEnd.frameQual')->with('frameLogs',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $posts = DB::select('SELECT * FROM frame_quals ORDER BY ID DESC LIMIT 1');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
       return view('backEnd.frameCreate')->with('frameLogs',$posts);
        
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
       // 'shift' => 'required', 
       // 'date' => 'required',
        'qualTime' => 'required',
        'serialNo'=> 'required',
        'L1woSealant' => 'required|numeric|min:700',
        'L1wSealant' => 'required|numeric|min:700',
        'L2woSealant' => 'required|numeric|min:700',
        'L2wSealant' => 'required|numeric|min:700',
        'S1wSealant' => 'required|numeric|min:500',
        'S1woSealant' => 'required|numeric|min:500',
        'S2wSealant' => 'required|numeric|min:500',
        'S2woSealant' => 'required|numeric|min:500',
     //   'S2diff' => 'required',
       // 'S1diff' => 'required',
        //'L2diff' => 'required',
        //'L1diff' => 'required',
        //'S2diff' => 'required',
        //'sum' =>  'required|numeric',
        'remarks' => 'required',
       //'remarks2' => 'required',
        'beadScale' => 'required|integer|min:1',
        'facilitySupply' => 'required|integer|min:1',
        'mainPressure' => 'required|integer|min:1'  
            ]); 
            
        $post = new frameQual;
        $post->qualTransID = $request->input('transID');
        $post->shift = $request->input('shift');
        $post->date = $request->input('fixture_date');
        $post->qualTime = $request->input('qualTime');
        $post->serialNo = $request->input('serialNo');
            $post->L1woSealantWt= $request ->input('L1woSealant');
            $post->L1wSealantWt= $request ->input('L1wSealant');
            $post->L2woSealantWt= $request ->input('L2woSealant');
            $post->L2wSealantWt= $request ->input('L2wSealant');
            $post->S1woSealantWt= $request ->input('S1woSealant');
            $post->S1wSealantWt= $request ->input('S1wSealant');
            $post->S2woSealantWt= $request ->input('S2woSealant');
            $post->S2wSealantWt= $request ->input('S2wSealant');
            $post->L1diff= $request ->input('L1diff');
            $post->L2diff= $request ->input('L2diff');
            $post->S1diff= $request ->input('S1diff');
            $post->S2diff= $request ->input('S2diff');
            $post->weight= $request ->input('sum');
            $post->beadScale= $request ->input('beadScale');
            $post->facilitySupply= $request ->input('facilitySupply');
            $post->mainPressure= $request ->input('mainPressure');
            $post->paramID= $request ->input('');
            $post->TargetParam= $request ->input('target');
            $post->qualResult= $request ->input('remarks');
            $post->remarks= $request ->input('remarks2');
       // $post->crossSection = $request->input('crossSection');
        $post->save();
        if($request->input('remarks')=="fail" && $request->input('serialNo')=="Frame Qual" ){
            $posts = DB::select('SELECT * FROM frame_quals ORDER BY ID DESC LIMIT 1');                                        
            //$posts  = Post::orderBy('created_at','desc')->paginate(2);
         //return redirect('Frame/create')->with('frameLogs',$posts);
          // return redirect()->route('create',['frameLogs'=>$posts]);
         return Redirect::route('Frame.create')
                           ->with('frameLogs',$posts)
                          ->with('error','Qual Failed! record was added. Add Another qual.');
           //->with('success','Qual Failed.Record was added.Add another qual.');
            //return redirect('/Frame')->with('success','Record was successfully added!');
        }elseif($request->input('remarks')=="pass" && $request->input('serialNo')=="Frame Qual" ){
            $posts = DB::select('SELECT * FROM frame_quals ORDER BY ID DESC LIMIT 1');                                        
            //$posts  = Post::orderBy('created_at','desc')->paginate(2);
            return Redirect::route('Frame.create')
            ->with('frameLogs',$posts)
           ->with('success','Qual Passed! record was added. Add Another qual with Serial No.');
            //return redirect('/Frame')->with('success','Record was successfully added!');
        }elseif($request->input('remarks')=="fail" && $request->input('serialNo')!="Frame Qual" ){
            $posts = DB::select('SELECT * FROM frame_quals ORDER BY ID DESC LIMIT 1');                                        
            //$posts  = Post::orderBy('created_at','desc')->paginate(2);
            return Redirect::route('Frame.create')
            ->with('frameLogs',$posts)
           ->with('error','Qual Failed! record was added. Add Another qual.');
            //return redirect('/Frame')->with('success','Record was successfully added!');
        }else{
            return redirect('/Frame')->with('success','Record was successfully added!');
        }
        
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
