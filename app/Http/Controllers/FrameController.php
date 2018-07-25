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
      //  $posts = DB::select('SELECT * FROM frame_quals ORDER BY ID DESC');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
     //   return view('backEnd.frameQual')->with('frameLogs',$posts);

     $tempAve = 0;
     $tempBefAveSTD = 0;
     $xbbfront = 0;
     $stdavg = 0;
     $median = 0;
     return view('backEnd.frameSum') 
->with('avefront',$tempAve)
->with('stdfront',$tempBefAveSTD)
->with('xbbfront',$xbbfront)
->with('stdavg',$stdavg)
->with('median',$median);


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
        

       

            if($request ->input('target')=='180'){
                $this->validate($request,[ 
                'L1diff' => 'required|numeric|between:50.00,70.00',
                'L2diff' => 'required|numeric|between:50.00,70.00',
                'S1diff' => 'required|numeric|between:20.00,40.00',
                'S2diff' => 'required|numeric|between:20.00,40.00',
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
               // 'L1diff' => 'required|between:50,70',
             //   'S2diff' => 'required',
               // 'S1diff' => 'required',
                //'L2diff' => 'required',
                //'L1diff' => 'required',
                //'S2diff' => 'required',
                //'sum' =>  'required|numeric',
                'remarks' => 'required',
               //'remarks2' => 'required',
                'beadScale' => 'required|numeric|between:50.00,120.00',
                'facilitySupply' => 'required|numeric|between:30.00,70.00',
                'mainPressure' => 'required|numeric|between:30.00,70.00'  
              ]);
           }else{


            $this->validate($request,[ 
                // 'shift' => 'required', 
                // 'date' => 'required',
                'L1diff' => 'required|numeric|between:37.00,57.00',
                'L2diff' => 'required|numeric|between:37.00,57.00',
                'S1diff' => 'required|numeric|between:18.00,38.00',
                'S2diff' => 'required|numeric|between:18.00,38.00',
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
               //  'L1diff' => 'required|between:50,70',
              //   'S2diff' => 'required',
                // 'S1diff' => 'required',
                 //'L2diff' => 'required',
                 //'L1diff' => 'required',
                 //'S2diff' => 'required',
                 //'sum' =>  'required|numeric',
                 'remarks' => 'required',
                //'remarks2' => 'required',
                'beadScale' => 'required|numeric|between:50.00,120.00',
                'facilitySupply' => 'required|numeric|between:30.00,70.00',
                'mainPressure' => 'required|numeric|between:30.00,70.00'  
                     ]); 

           }
            
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
        if($request->input('remarks')=="fail" && $request->input('serialNo')=="Qual Frame" ){
            $posts = DB::select('SELECT * FROM frame_quals ORDER BY ID DESC LIMIT 1');                                        
          
         return Redirect::route('Frame.create')
                           ->with('frameLogs',$posts)
                          ->with('error','Qual Failed! record was added. Add Another qual.');
           //
        }elseif($request->input('remarks')=="pass" && $request->input('serialNo')=="Qual Frame" ){
            $posts = DB::select('SELECT * FROM frame_quals ORDER BY ID DESC LIMIT 1');                                        
          
        return Redirect::route('Frame.create')
            ->with('frameLogs',$posts)
           ->with('success','Qual Passed! record was added. Add Another qual with Serial No.');
         
        }elseif($request->input('remarks')=="fail" && $request->input('serialNo')!="Qual Frame" ){
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
