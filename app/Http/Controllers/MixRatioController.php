<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\pottantQual;
//use DB;

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
        $passVal = DB::select('SELECT sampleCount,qualTransID,id, qualRes FROM pottant_quals ORDER BY ID DESC LIMIT 1');
        foreach ($passVal as $val2) { $qualid = $val2->qualTransID; }
       //$count = $passVal->count();
       $post = new pottantQual;
       $pot = $post::count();
        if($pot>0){
            $posts = DB::select('SELECT * FROM pottant_quals WHERE qualTransID = "'.$qualid.'"');  
            // return view('backEnd.potMixingRatioCreate');
            return view('backEnd.potMixingRatioCreate')->with('frameLogs',$posts);
        }else{
            $posts = DB::select('SELECT * FROM pottant_quals');                                        
            //$posts  = Post::orderBy('created_at','desc')->paginate(2);
              return view('backEnd.potMixingRatioCreate')->with('frameLogs',$posts);
          //  return view('backEnd.potMixingRatioCreate');
        } 
       
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
           // 'pottantWt' =>'required|integer|min:1',
         //   'snapTime' => 'required',
            'qualTime' => 'required',
            'dispensedWtA' => 'required|numeric|min:1',
            'dispensedWtB' => 'required|numeric|min:1'
        ]);
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

        $curResVal = "";
        $curSampCntVal = 0;
        $curQualTransID = 0;
        $checkVar = 0;
        $passedCount = 0;
        $inputRes = "";
        $lastval ="";
        $lastval2 ="";
       // $inputRes =  ;


       if($pot > 0)
        {
            if( $request ->input('qualRes')=="passed"){

                
                $passVal = DB::select('SELECT sampleCount,qualTransID,id, qualRes FROM pottant_quals ORDER BY ID DESC LIMIT 1');
                foreach ($passVal as $val2) { $qualid = $val2->id - 1; $qualid2 = $val2->id - 2; }
                $passedVal = DB::select('SELECT sampleCount,qualTransID,id,qualRes FROM pottant_quals WHERE id ="'.$qualid.'"');
                foreach ($passedVal as $val3) {  $lastval = $val3->qualRes; }
                foreach ($passVal as $val) {
                if($val->qualRes == "passed")
                {   
                    if($val->sampleCount < 9){
                       


                    $countPassedQual1 = DB::table('pottant_quals')
                    ->orderBy('id','desc')
                    ->take(4)
                    ->get();
                    $countPassedQual3 = $countPassedQual1->where('qualRes','passed');
                    $countPQ2 = $countPassedQual3->count();
                        if( $countPQ2 == 4)
                        {
                            $lastid = $val->qualTransID - 1;
                            if($val->qualTransID !=  $lastid && $val->sampleCount < 2 ){

                                $checkVar = 0;
                                $curResVal = $val->qualRes;
                                $curSampCntVal = $val->sampleCount;
                                $curQualTransID = $val->qualTransID ;   
                                $post->sampleCount = $curSampCntVal + 1;
                                $post->qualTransID = $curQualTransID; 
                           
                        }else if($val->qualTransID !=  $lastid && $val->sampleCount == 2 ){

                            $checkVar = 3;
                            $curResVal = $val->qualRes;
                            $curSampCntVal = $val->sampleCount;
                            $curQualTransID = $val->qualTransID ;   
                            $post->sampleCount = $curSampCntVal + 1;
                            $post->qualTransID = $curQualTransID; 
                       
                    }else if($val->qualTransID !=  $lastid && $val->sampleCount == 3 ){

                            $checkVar = 0;
                            $post->sampleCount = 0;
                            $curResVal = $val->qualRes;
                            $curSampCntVal = 0;
                            $curQualTransID = $val->qualTransID + 1 ;   
                            $post->sampleCount = $curSampCntVal + 1;
                            $post->qualTransID = $curQualTransID;
                       
                        
                   
                        }
                            

                        }else
                            {

                 
                    $countPassedQual = DB::table('pottant_quals')
                    ->orderBy('id','desc')
                    ->take(3)
                    ->get();
                    $countPassedQual2 = $countPassedQual->where('qualRes','passed');
                    $countPQ = $countPassedQual2->count();
                    
                    $countTransQual = DB::table('pottant_quals')
                    ->orderBy('id','desc')
                    ->take(3)
                    ->get();
                    $countTransQual2 =  $countTransQual->where('qualTransID', $val->qualTransID);
                    $countTQ =  $countTransQual2->count();
                    

                    if( $countPQ == 3 && $countTQ == 3 ){
                        
                            $checkVar = 0;
                            $post->sampleCount = 0;
                            $curResVal = $val->qualRes;
                            $curSampCntVal = 0;
                            $curQualTransID = $val->qualTransID + 1 ;   
                            $post->sampleCount = $curSampCntVal + 1;
                            $post->qualTransID = $curQualTransID;
                       
                    }else{
                   
                            $countPassed = DB::table('pottant_quals')
                            // ->where('qualRes','passed')
                             ->orderBy('id','desc')
                              ->take('2')
                             ->get();
                             $countPassed3 = $countPassed->where('qualRes','passed');
                             $countP = $countPassed3->count();
                            
                            
                          if ( $countP == 2){
                              // 3 kanina toh
                            $checkVar = 3;
                             $curResVal = $val->qualRes;
                             $curSampCntVal = $val->sampleCount;
                             $curQualTransID = $val->qualTransID  ;   
                             $post->sampleCount = $curSampCntVal + 1;
                             //$post->sampleCount = $passedCount;
                             $post->qualTransID = $curQualTransID;
                             //$post->sampleCount = $passedCount; 
                           //  return $countP.'if 2';
                         }else if ( $countP == 1){
                         $checkVar = 0;
                         $curResVal = $val->qualRes;
                         $curSampCntVal = $val->sampleCount;
                         $curQualTransID = $val->qualTransID ;   
                         $post->sampleCount = $curSampCntVal + 1;
                         //$post->sampleCount = $passedCount;
                         $post->qualTransID = $curQualTransID; 

                       //  return $countP.'if 1';

                         }else{
                         $checkVar = 0;
                         $curResVal = $val->qualRes;
                         $curSampCntVal = $val->sampleCount;
                         $curQualTransID = $val->qualTransID ;   
                         $post->sampleCount = $curSampCntVal + 1;
                         //$post->sampleCount = $passedCount;
                         $post->qualTransID = $curQualTransID; 

                     //    return $countPQ.' else';
                         }
                        }

                       
                        }
                    }else if($val->sampleCount == 9){
                        $checkVar = 4;
                        $curResVal = $val->qualRes;
                        $curSampCntVal = $val->sampleCount;
                        $curQualTransID = $val->qualTransID ;   
                        $post->sampleCount = $curSampCntVal + 1;
                        //$post->sampleCount = $passedCount;
                        $post->qualTransID = $curQualTransID;
                    }
                        else if($val->sampleCount == 10){
                            $checkVar = 0;
                        $post->sampleCount = 0;
                        $curResVal = $val->qualRes;
                        $curSampCntVal = 0;
                        //$curQualTransID = 0;
                        $curQualTransID = $val->qualTransID + 1 ;   
                        $post->sampleCount = $curSampCntVal + 1;
                        $post->qualTransID = $curQualTransID;
                        }

                    

                    }
                    
                else{
                    if($val->sampleCount < 9){
                    
                        $checkVar = 0;
                        $curResVal = $val->qualRes;
                        $curSampCntVal = $val->sampleCount;
                        $curQualTransID = $val->qualTransID ;   
                        $post->sampleCount = $curSampCntVal + 1;
                        $post->qualTransID = $curQualTransID; 
                    }else if($val->sampleCount == 9){
                    $checkVar = 4;
                    $curResVal = $val->qualRes;
                    $curSampCntVal = $val->sampleCount;
                    $curQualTransID = $val->qualTransID ;   
                    $post->sampleCount = $curSampCntVal + 1;
                    //$post->sampleCount = $passedCount;
                    $post->qualTransID = $curQualTransID;
                    }else if($val->sampleCount == 10){
                        $checkVar = 0;
                        $post->sampleCount = 0;
                        $curResVal = $val->qualRes;
                        $curSampCntVal = 0;
                        //$curQualTransID = 0;
                        $curQualTransID = $val->qualTransID + 1 ;   
                        $post->sampleCount = $curSampCntVal + 1;
                        $post->qualTransID = $curQualTransID;
                        }
                }

                if($checkVar == 0){
                    $post->save();  
                  //  return redirect('/MixRatio/create')->with('success','Record was successfully added!add another qual to complete 3 consecutive passed qual.');
                  $posts = DB::select('SELECT * FROM pottant_quals WHERE qualTransID = "'.$post->qualTransID.'"');    
                  return Redirect::route('MixRatio.create')
                           ->with('frameLogs',$posts)
                          ->with('success','Record was successfully added!add another qual to complete 3 consecutive passed qual.');
                }
                if($checkVar == 3){
                    $post->save();  
                    return redirect('/MixRatio')->with('success','Record was successfully added!3 consecutive qual has been passed.');
                 
                } if($checkVar == 4){
                    $post->save();  
                    return redirect('/MixRatio')->with('success','Qual Passed!but only 10 quals per set is allowed.Add another set of qual.');
                 
                } 
         
           
            }
            }else{
              $passVal3 =  DB::select('SELECT * FROM pottant_quals ORDER BY ID DESC LIMIT 1');
                foreach ($passVal3 as $val) {
                   
               
                    if($val->sampleCount < 9){

                        $countfailQual = DB::table('pottant_quals')
                        ->orderBy('id','desc')
                        ->take(3)
                        ->get();
                        $countfailQual2 = $countfailQual->where('qualRes','passed');
                        $countFQ = $countfailQual2->count();

                        if( $countFQ == 3 ){
                            if($val->sampleCount < 3){
                                $checkVar = 1;
                               $curResVal = $val->qualRes;
                               $curSampCntVal = $val->sampleCount;
                               $curQualTransID = $val->qualTransID ;   
                               $post->sampleCount = $curSampCntVal + 1;
                               $post->qualTransID = $curQualTransID;
                           }else{
                            $checkVar = 1;
                            $curResVal = $val->qualRes;
                            $curSampCntVal = 0;
                            $curQualTransID = $val->qualTransID + 1 ;   
                            $post->sampleCount = $curSampCntVal + 1;
                            $post->qualTransID = $curQualTransID;
                           }
                        }
                        else{

                           
                                $checkVar = 1;
                                $curResVal = $val->qualRes;
                                $curSampCntVal = $val->sampleCount;
                                $curQualTransID = $val->qualTransID ;   
                                $post->sampleCount = $curSampCntVal + 1;
                                $post->qualTransID = $curQualTransID;
                            
                        }

                           
                        } else if($val->sampleCount == 9){
                            $checkVar = 2;
                            $curResVal = $val->qualRes;
                            $curSampCntVal = $val->sampleCount;
                            $curQualTransID = $val->qualTransID ;   
                            $post->sampleCount = $curSampCntVal + 1;
                            $post->qualTransID = $curQualTransID;
                        }
                    else if($val->sampleCount == 10){
                        $checkVar = 1;
                        $post->sampleCount = 0;
                        $curResVal = $val->qualRes;
                        $curSampCntVal = 0;
                        $curQualTransID = 0;
                        $curQualTransID = $val->qualTransID + 1 ;   
                        $post->sampleCount = $curSampCntVal + 1;
                        $post->qualTransID = $curQualTransID;
                    }
                    if($checkVar == 1){
                        $post->save();  
                      //  return redirect('/MixRatio/create')->with('error','Qual Failed!add another qual to complete 3 consecutive passed qual.');
                      $posts = DB::select('SELECT * FROM pottant_quals WHERE qualTransID = "'.$post->qualTransID.'"');    
                      return Redirect::route('MixRatio.create')
                               ->with('frameLogs',$posts)
                               ->with('error','Qual Failed!add another qual to complete 3 consecutive passed qual.');
                    }
             
                if($checkVar == 2){
                        $post->save();  
                      // return redirect('/MixRatio/create')->with('error','Qual Failed! Add another set of Qual.');
                      $posts = DB::select('SELECT * FROM pottant_quals WHERE qualTransID = "'.$post->qualTransID.'"');  
                        return Redirect::route('MixRatio.create')
                               ->with('frameLogs',$posts)
                               ->with('error','Qual Failed! Add another set of Qual.');
                    }
                }
                           
                        
                        
                       

                  
                      
                    }



            
            

         } else{ 
        
            if( $request ->input('qualRes')=="passed"){
        $post->sampleCount = '1';
        $post->qualTransID = '1';
        $post->save();
        //return redirect('/MixRatio/create')->with('success','Record was successfully added!');
        $posts = DB::select('SELECT * FROM pottant_quals WHERE qualTransID = "'.$post->qualTransID.'"');  
                        return Redirect::route('MixRatio.create')
                               ->with('frameLogs',$posts)
                               ->with('success','Record was successfully added!');
        }else{
            $post->sampleCount = '1';
            $post->qualTransID = '1';
            $post->save();
           // return redirect('/MixRatio/create')->with('error','Qual Failed! Record was successfully added.');
           $posts = DB::select('SELECT * FROM pottant_quals WHERE qualTransID = "'.$post->qualTransID.'"');  
                        return Redirect::route('MixRatio.create')
                               ->with('frameLogs',$posts)
                               ->with('error','Qual Failed! Record was successfully added.');
        }
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
