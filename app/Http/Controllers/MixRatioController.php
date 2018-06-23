<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\pottantQual;

class MixRatioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::select('SELECT * FROM pottant_quals');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
          return view('backEnd.potMixingRatio')->with('MixLogs',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backEnd.potMixingRatioCreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $post = new pottantQual;
      //  $post->qualTransID = $request->input('transID');
        $post->shift = $request->input('shift');
        $post->date = $request->input('fixture_date');
        $post->qualTime = $request->input('qualTime');
       // $post->sampleCount = $request->input('sampCount');
        $post->befDispenseWtA= $request ->input('befDispenseWtA');
        $post->befDispenseWtB= $request ->input('befDispenseWtB');
        $post->dispensedWtA= $request ->input('dispensedWtA');
        $post->dispensedWtB= $request ->input('dispensedWtB');
        $post->weightA= $request ->input('weightA');
        $post->weightB= $request ->input('weightB');
        $post->totalWt= $request ->input('totalWt');
        $post->targetWt= $request ->input('target');
        $post->ratioVal= $request ->input('ratio');
        $post->ratioTargetS= $request ->input('ratioFrom');
        $post->ratioTargetE= $request ->input('ratioTo');
        $post->qualRes= $request ->input('qualRes');
       // $post->crossSection = $request->input('crossSection');
       
      // foreach ($post as $val) {
      //  if($val->qualRes
    //}
      /*  $count = 0;
        $count =  DB::select('SELECT * FROM frame_quals ORDER BY ID DESC LIMIT 1')->exists();
        $post->sampleCount = $count;
        $post->transID = $count;

        */
        
   
       // $pot = DB::table('frame_quals')->count();
        $pot = $post::count();
       if($pot > 0)
        {
            $curResVal = "";
            $curSampCntVal = 0;
            $curQualTransID = 0;
            $checkVar = 0;
         if( $request ->input('qualRes')=="passed"){
            $passVal =  DB::select('SELECT * FROM pottant_quals ORDER BY ID DESC LIMIT 2');

           
            
            foreach ($passVal as $val) {
                if($val->qualRes == "passed")
                {                
                    if($curSampCntVal <= 1){
                      
                        $checkVar = 0;
                        $curResVal = $val->qualRes;
                        $curSampCntVal = $val->sampleCount;
                        $curQualTransID = $val->qualTransID;   
                        $post->sampleCount = $curSampCntVal + 1;
                        $post->qualTransID = $curQualTransID;
                    }else if($curSampCntVal == 2)
                    {
                        $checkVar = 0;
                        $curResVal = $val->qualRes;
                        $curSampCntVal = $val->sampleCount;
                        $curQualTransID = $val->qualTransID;   
                        $post->sampleCount = $curSampCntVal + 1;
                        $post->qualTransID = $curQualTransID;
                    }else if($curSampCntVal == 3)
                    {
                        $checkVar = 0;
                        $curResVal = $val->qualRes;
                        $curSampCntVal = 0;
                        $curQualTransID = $val->qualTransID + 1;   
                        $post->sampleCount = $curSampCntVal + 1;
                        $post->qualTransID = $curQualTransID;
                    }
                   
                }else{

                    $checkVar = 1;
                    $curResVal = $val->qualRes;
                    $curSampCntVal = $val->sampleCount;
                    $curQualTransID = $val->qualTransID;   
                    $post->sampleCount = $curSampCntVal + 1;
                    $post->qualTransID = $curQualTransID;

                }
                
            if($checkVar == 0){
                if($curSampCntVal <= 1 ){
                    $post->save();  
                    return redirect('/MixRatio/create')->with('success','Record was successfully added!add another qual.');
                   // return redirect('/MixRatio/create')->with('success','more than 1 record'.$pot);
                }else if($curSampCntVal == 2){
                    $post->save();  
                    return redirect('/MixRatio')->with('success','Record was successfully added!3 consecutive qual passed.');
                   // return redirect('/MixRatio/create')->with('success','more than 1 record'.$pot);
                }
              
            }
            
            }


          
            }
                
                
                
         } else{ 
        
        
        $post->sampleCount = '1';
        $post->qualTransID = '1';
        $post->save();
        return redirect('/MixRatio')->with('success','Record was successfully added!');
       // return redirect('/MixRatio/create')->with('success','else.'.$pot);  
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
