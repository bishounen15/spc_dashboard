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
      //  $posts = DB::select('SELECT * FROM pottant_quals');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);


$weightAve30 = DB::table(DB::select("SELECT AVG(ratioVal) as aveWt FROM (SELECT ratioVal FROM pottant_quals WHERE date IN (SELECT * FROM view_mixingratioby30) )as tblview"));
$wtAve30 = number_format($weightAve30->from[0]->aveWt,6);
$weightAve7 = DB::table(DB::select("SELECT AVG(ratioVal) as aveWt FROM (SELECT ratioVal FROM pottant_quals WHERE date IN (SELECT * FROM view_mixingratioby7) )as tblview"));
$wtAve7 = number_format($weightAve7->from[0]->aveWt,6);

$weightStd30 = DB::table(DB::select("SELECT STDDEV_SAMP(ratioVal) as aveStd FROM  (SELECT ratioVal FROM pottant_quals WHERE date IN (SELECT * FROM view_mixingratioby30) )as tblview"));
$wtStd30 = number_format($weightStd30->from[0]->aveStd,6);
$weightStd7 = DB::table(DB::select("SELECT STDDEV_SAMP(ratioVal) as aveStd FROM  (SELECT ratioVal FROM pottant_quals WHERE date IN (SELECT * FROM view_mixingratioby7) )as tblview"));
$wtStd7 = number_format($weightStd7->from[0]->aveStd,6);


$weightAveOfAve = DB::table(DB::select("SELECT AVG(aveOfAve) as aveRatio FROM (SELECT date,AVG(ratioVal) as aveOfAve FROM (SELECT date, ratioVal FROM pottant_quals WHERE date IN (SELECT * FROM view_mixingratioby30) )as tblview GROUP BY date) as tblavgofavg"));
$wtAveOfAve = number_format($weightAveOfAve->from[0]->aveRatio,6);

$weightStdOfStd = DB::table(DB::select("SELECT STDDEV_SAMP(aveOfAve) as aveRatio FROM (SELECT date,AVG(ratioVal) as aveOfAve FROM (SELECT date, ratioVal FROM pottant_quals WHERE date IN (SELECT * FROM view_mixingratioby30) )as tblview GROUP BY date) as tblavgofavg"));
$wtStdOfStd = number_format($weightStdOfStd->from[0]->aveRatio,6);

$medianSql30 = "SELECT ROUND(AVG(ratioVal),6) as aveWt FROM (SELECT * FROM pottant_quals WHERE date IN (SELECT * FROM view_mixingratioby30) )as tblview GROUP BY date ORDER BY aveWt ASC";
$medianCount30 = "SELECT COUNT(aveWt) as aveCount FROM (SELECT ROUND(AVG(ratioVal),6) as aveWt FROM (SELECT * FROM pottant_quals WHERE date IN (SELECT * FROM view_mixingratioby30) )as tblview GROUP BY date ORDER BY aveWt ASC) as tblcnt" ;
$medianAve30 = $this->getMedian($medianSql30,$medianCount30);

$medianSql7 = "SELECT ROUND(AVG(ratioVal),6) as aveWt FROM (SELECT * FROM pottant_quals WHERE date IN (SELECT * FROM view_mixingratioby7) )as tblview GROUP BY date ORDER BY aveWt ASC";
$medianCount7 = "SELECT COUNT(aveWt) as aveCount FROM (SELECT ROUND(AVG(ratioVal),6) as aveWt FROM (SELECT * FROM pottant_quals WHERE date IN (SELECT * FROM view_mixingratioby7) )as tblview GROUP BY date ORDER BY aveWt ASC) as tblcnt" ;
$medianAve7 = $this->getMedian($medianSql7,$medianCount7);

$list30 ="SELECT date,AVG(ratioVal) as aveWt FROM (SELECT date, ratioVal FROM pottant_quals WHERE date IN (SELECT * FROM view_mixingratioby30) )as tblview GROUP BY date";
$percentile30 = $this->getList4percentile($list30,0.00135,$medianCount30);
$percentile30_1 = $this->getList4percentile($list30,0.99865,$medianCount30);

$list7 ="SELECT date,AVG(ratioVal) as aveWt FROM (SELECT date, ratioVal FROM pottant_quals WHERE date IN (SELECT * FROM view_mixingratioby7) )as tblview GROUP BY date";
$percentile7 = $this->getList4percentile($list7,0.00135,$medianCount7);
$percentile7_1 = $this->getList4percentile($list7,0.99865,$medianCount7);

$UCL=6.24;
$LCL=5.64;
$CL = (($UCL-$LCL)/2)+$LCL;
$target = 6;
$USL = $target + 0.02;
$LSL = $target - 0.02;

$CpL_30 = ($wtAveOfAve-$LCL)/(3*$wtStdOfStd);
$CpU_30 = ($UCL-$wtAveOfAve)/(3*$wtStdOfStd);


$CpL_7 = ($wtAve7 -$LCL)/(3*$wtStd7 );
$CpU_7 = ($UCL-$wtAve7 )/(3*$wtStd7 );

$arrValForCpk_30 = array($CpU_30,$CpL_30);
$arrValForCpk_7 = array($CpU_7,$CpL_7);

$Cpk_30 = min($arrValForCpk_30);
$Cpk_7 = min($arrValForCpk_7);

$CpnU_30 = ($USL - $medianAve30)/($percentile30_1 - $medianAve30);
$CpnL_30 = ($medianAve30 - $LSL)/($medianAve30 - $percentile30);
$CpnU_7 = ($USL - $medianAve7)/($percentile7_1 - $medianAve7);
$CpnL_7 = ($medianAve7 - $LSL)/($medianAve7 - $percentile7);

$arrValForCpn_30 = array($CpnU_30,$CpnL_30);
$arrValForCpn_7 = array($CpnU_7,$CpnL_7);
$Cpn_30 = min($arrValForCpn_30);
$Cpn_7 = min($arrValForCpn_7);

$zValue_30 = ABS(number_format(($wtAveOfAve-$CL)/$wtStdOfStd,4));
$zValue_7 = ABS(number_format(($wtAve7 -$CL)/$wtStd7,4));

          return view('backEnd.potMixRatioSum')
          ->with('wtAve30',$wtAve30)
          ->with('wtStd30',$wtStd30)
          ->with('wtAve7',$wtAve7)
          ->with('wtStd7',$wtStd7)
          ->with('wtAveOfAve',$wtAveOfAve)
          ->with('wtStdOfStd',$wtStdOfStd)
          ->with('medianAve30',$medianAve30)
          ->with('medianAve7',$medianAve7)
          ->with('percentile7',$percentile7)
          ->with('percentile7_1',$percentile7_1)
          ->with('percentile30',$percentile30)
          ->with('percentile30_1',$percentile30_1)
          ->with('zValue_30',$zValue_30)
          ->with('zValue_7',$zValue_7)
          ->with('UCL',$UCL)
          ->with('LCL',$LCL)
->with('CL',$CL)
->with('target',$target)
->with('USL',$USL)
->with('LSL',$LSL)
->with('CpL_30',number_format($CpL_30,2))
->with('CpU_30',number_format($CpU_30,2))
->with('Cpk_30',number_format($Cpk_30,2))
->with('Cpn_30',number_format($Cpn_30,2))
->with('CpnU_30',number_format($CpnU_30,2))
->with('CpnL_30',number_format($CpnL_30,2))
->with('CpL_7',number_format($CpL_7,2))
->with('CpU_7',number_format($CpU_7,2))
->with('Cpk_7',number_format($Cpk_7,2))
->with('Cpn_7',number_format($Cpn_7,2))
->with('CpnU_7',number_format($CpnU_7,2))
->with('CpnL_7',number_format($CpnL_7,2));


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

   

    public function mypercentile($data,$percentile){ 
        if( 0 < $percentile && $percentile < 1 ) { 
            $p = $percentile; 
        }else if( 1 < $percentile && $percentile <= 100 ) { 
            $p = $percentile * .01; 
        }else { 
            return ""; 
        } 
        $count = count($data); 
        $allindex = ($count-1)*$p; 
        $intvalindex = intval($allindex); 
        $floatval = $allindex - $intvalindex; 
        sort($data); 
        if(!is_float($floatval)){ 
            $result = $data[$intvalindex]; 
        }else { 
            if($count > $intvalindex+1) 
                $result = number_format(($floatval*($data[$intvalindex+1] - $data[$intvalindex]) + $data[$intvalindex]),4); 
            else 
                $result = $data[$intvalindex]; 
        } 
        return $result; 
    } 
    public function getMedian($medianSql, $medianCount)
    {
        $median = DB::table(DB::select($medianSql));
        $medianCount = DB::table(DB::select($medianCount));

        $medianCountVal = $medianCount->from[0]->aveCount;
        $medianMod = $medianCountVal%2;
        if($medianMod == 0){
        $midval1 = ($medianCountVal/2);
        $midval2 = $midval1 - 1;
        $medianVal1 = number_format($median->from[$midval1]->aveWt,6);  
        $medianVal2 = number_format($median->from[$midval2]->aveWt,6);
        $medianAve =number_format((($medianVal1 + $medianVal2)/2),6);
        return $medianAve;
        }else{
        $midval1 = number_format(($medianCountVal/2),2);
        $midval2 = round($midval1,1);
        $medianVal = number_format($median->from[$midval2]->aveWt,6);
        $medianAve = number_format($medianVal,6);
        return $medianAve;

}
     }
     public function getList4percentile($qry,$percentdec,$medianCountVal){
        $medianCount = DB::table(DB::select($medianCountVal));
        $wtAveList = DB::table(DB::select($qry));
        $medianCountValue = $medianCount->from[0]->aveCount;
        //dd($median);
        $arrAve = array();
        
        $arrVal= "";
        for($i=0;$i<$medianCountValue ;$i++){
          //  $arrVal= $arrVal.$wtAveList->from[$i]->aveWt.',';
            array_push($arrAve,$wtAveList->from[$i]->aveWt);
        }

        $percentile = $this->mypercentile($arrAve,$percentdec);
        return $percentile;
      
     }

}