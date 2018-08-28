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

     
     
$weightAve = DB::table(DB::select("SELECT AVG(weight) as aveWt FROM (SELECT weight FROM frame_quals WHERE date IN (SELECT * FROM view_framequals) )as tblview"));

$wtAve = number_format($weightAve->from[0]->aveWt,6);

$weightStd = DB::table(DB::select("SELECT STDDEV_SAMP(weight) as aveStd FROM (SELECT weight FROM frame_quals WHERE date IN (SELECT * FROM view_framequals) )as tblview"));
$wtStd = number_format($weightStd->from[0]->aveStd,6);

$weightAveOfAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM (SELECT AVG(weight) as aveWt FROM (SELECT * FROM frame_quals WHERE date IN (SELECT * FROM view_framequals) )as tblview GROUP BY date) as tbl_avgOfAvg"));
$wtAveOfAve = number_format($weightAveOfAve->from[0]->aveOfAve,6);

$weightStdOfStd = DB::table(DB::select("SELECT STDDEV_SAMP(stdWt) as stdOfStd FROM (SELECT AVG(weight) as stdWt FROM (SELECT * FROM frame_quals WHERE date IN (SELECT * FROM view_framequals) )as tblview GROUP BY date) as tbl_stdOfStd"));
$wtStdOfStd = number_format($weightStdOfStd->from[0]->stdOfStd,6);

$median = DB::table(DB::select("SELECT ROUND(AVG(weight),6) as aveWt FROM (SELECT * FROM frame_quals WHERE date IN (SELECT * FROM view_framequals) )as tblview GROUP BY date ORDER BY aveWt ASC"));
$medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM (SELECT ROUND(AVG(weight),6) as aveWt FROM (SELECT * FROM frame_quals WHERE date IN (SELECT * FROM view_framequals) )as tblview GROUP BY date ORDER BY aveWt ASC) as tblcnt"));
$medianCountVal = $medianCount->from[0]->aveCount;
$medianMod = $medianCountVal%2;


if($medianMod == 0){
    $midval1 = ($medianCountVal/2);
   $midval2 = $midval1 - 1;
  $medianVal1 = number_format($median->from[$midval1]->aveWt,6);  
$medianVal2 = number_format($median->from[$midval2]->aveWt,6);
$medianAve =number_format((($medianVal1 + $medianVal2)/2),6);
//$medianAve = $medianMod;
}else{
    $midval1 = number_format(($medianCountVal/2),2);
 $midval2 = round($midval1,1);
 $medianVal = number_format($median->from[$midval2]->aveWt,6);
   $medianAve = number_format($medianVal,6);
 // $medianAve = $medianMod;
}

$wtAveList = DB::table(DB::select("SELECT AVG(weight) as aveWt FROM (SELECT * FROM frame_quals WHERE date IN (SELECT * FROM view_framequals) )as tblview GROUP BY date"));
//dd($median);
$arrAve = array();




$arrVal= "";
for($i=0;$i<$medianCountVal ;$i++){
  //  $arrVal= $arrVal.$wtAveList->from[$i]->aveWt.',';
    array_push($arrAve,$wtAveList->from[$i]->aveWt);
}


$percentile = $this->mypercentile($arrAve,0.00135);
$percentile2 = $this->mypercentile($arrAve,0.99865);

     //$tempBefAveSTD = 0;
     $UCL=195;
$LCL=167;
$CL = (($UCL-$LCL)/2)+$LCL;
$target = 180;
$USL = $target + 25;
$LSL = $target - 20;
$CpL = ($wtAveOfAve-$LCL)/(3*$wtStdOfStd);
$CpU = ($UCL-$wtAveOfAve)/(3*$wtStdOfStd);
$arrValForCpk = array($CpU,$CpL);
$Cpk = min($arrValForCpk);
$CpnU = ($USL - $medianAve)/($percentile2 - $medianAve);
$CpnL = ($medianAve - $LSL)/($medianAve - $percentile);
$arrValForCpn = array($CpnU,$CpnL);
$Cpn = min($arrValForCpn);
$zValue = ABS(number_format(($wtAveOfAve-$CL)/$wtStdOfStd,4));
     $xbbfront = 0;
     $stdavg = 0;
     $median = 0;
     return view('backEnd.frameSum') 
->with('avefront',$wtAve)
->with('stdfront',$wtStd)
->with('xbbfront',$wtAveOfAve)
->with('stdavg',$wtStdOfStd)
->with('median',$medianAve)
->with('percentile',$percentile)
->with('percentile2',$percentile2)
->with('zValue',$zValue)
->with('UCL',$UCL)
->with('LCL',$LCL)
->with('CL',$CL)
->with('target',$target)
->with('USL',$USL)
->with('LSL',$LSL)
->with('CpL',number_format($CpL,2))
->with('CpU',number_format($CpU,2))
->with('Cpk',number_format($Cpk,2))
->with('Cpn',number_format($Cpn,2))
->with('CpnU',number_format($CpnU,2))
->with('CpnL',number_format($CpnL,2));




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
        

       if($request->input('fromDate')!=''&&$request->input('toDate')!=''){
           $from = $request->input('fromDate');
           $to = $request->input('toDate');
       
$weightAve = DB::table(DB::select("SELECT AVG(weight) as aveWt FROM (SELECT weight FROM frame_quals WHERE date IN (SELECT distinct(date) FROM `frame_quals` WHERE date BETWEEN '".$from."' AND '".$to."') )as tblview"));
//->select(DB::raw("AVG(weight) as aveWt"))
// ->get();

$wtAve = number_format($weightAve->from[0]->aveWt,2);

$weightStd = DB::table(DB::select("SELECT STDDEV_SAMP(weight) as aveStd FROM (SELECT weight FROM frame_quals WHERE date IN (SELECT distinct(date) FROM `frame_quals` WHERE date BETWEEN '".$from."' AND '".$to."') )as tblview"));
$wtStd = number_format($weightStd->from[0]->aveStd,6);

$weightAveOfAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM (SELECT AVG(weight) as aveWt FROM (SELECT * FROM frame_quals WHERE date IN (SELECT distinct(date) FROM `frame_quals` WHERE date BETWEEN '".$from."' AND '".$to."') )as tblview GROUP BY date) as tbl_avgOfAvg"));
$wtAveOfAve = number_format($weightAveOfAve->from[0]->aveOfAve,6);

$weightStdOfStd = DB::table(DB::select("SELECT STDDEV_SAMP(stdWt) as stdOfStd FROM (SELECT AVG(weight) as stdWt FROM (SELECT * FROM frame_quals WHERE date IN (SELECT distinct(date) FROM `frame_quals` WHERE date BETWEEN '".$from."' AND '".$to."') )as tblview GROUP BY date) as tbl_stdOfStd"));
$wtStdOfStd = number_format($weightStdOfStd->from[0]->stdOfStd,6);

$median = DB::table(DB::select("SELECT ROUND(AVG(weight),6) as aveWt FROM (SELECT * FROM frame_quals WHERE date IN (SELECT distinct(date) FROM `frame_quals` WHERE date BETWEEN '".$from."' AND '".$to."') )as tblview GROUP BY date ORDER BY aveWt ASC"));
$medianVal1 = number_format($median->from[14]->aveWt,6);  
$medianVal2 = number_format($median->from[15]->aveWt,6);
$medianAve = number_format((($medianVal1 + $medianVal2)/2),6);
//$medianAve = $median::count();
// $wtAve = 0;
$wtAveList = DB::table(DB::select("SELECT AVG(weight) as aveWt FROM (SELECT * FROM frame_quals WHERE date IN (SELECT distinct(date) FROM `frame_quals` WHERE date BETWEEN '".$from."' AND '".$to."') )as tblview GROUP BY date"));
//dd($medianAve);
$arrAve = array();



$arrVal= "";
for($i=0;$i<30;$i++){
  //  $arrVal= $arrVal.$wtAveList->from[$i]->aveWt.',';
    array_push($arrAve,$wtAveList->from[$i]->aveWt);
}


$percentile = $this->mypercentile($arrAve,0.00135);
$percentile2 = $this->mypercentile($arrAve,0.99865);
$UCL=195;
$LCL=167;

$CL = (($UCL-$LCL)/2)+$LCL;
$zValue = ABS(number_format(($wtAveOfAve-$CL)/$wtStdOfStd,4));
     //$tempBefAveSTD = 0;

$target = 180;
$USL = $target + 25;
$LSL = $target - 20;
$CpL = ABS(number_format(($wtAveOfAve-$LCL)/(3*$wtStdOfStd),4));
$CpU = ABS(number_format(($UCL-$wtAveOfAve)/(3*$wtStdOfStd),4));

$arrValForCpk = array($CpU,$CpL);
$Cpk = min($arrValForCpk);
$CpnU = ($USL - $medianAve)/($percentile2 - $medianAve);
$CpnL = ($medianAve - $LSL)/($medianAve - $percentile);
$arrValForCpn = array($CpnU,$CpnL);
$Cpn = min($arrValForCpn);
     $xbbfront = 0;
     $stdavg = 0;
     $median = 0;
     return view('backEnd.frameSum') 
->with('avefront', $wtAve)
->with('stdfront',$wtStd)
->with('xbbfront',$wtAveOfAve)
->with('stdavg',$wtStdOfStd)
->with('median',$medianAve)
->with('percentile',$percentile)
->with('percentile2',$percentile2)
->with('zValue',$zValue)
->with('UCL',$UCL)
->with('LCL',$LCL)
->with('CL',$CL)
->with('target',$target)
->with('USL',$USL)
->with('LSL',$LSL)
->with('CpL',number_format($CpL,2))
->with('CpU',number_format($CpU,2))
->with('Cpk',number_format($Cpk,2))
->with('Cpn',number_format($Cpn,2))
->with('CpnU',number_format($CpnU,2))
->with('CpnL',number_format($CpnL,2));
       }

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

    public function getSumByRange(){
        
    }
   /* public function get_percentile($percentile, $array) {
        sort($array);
        $index = ($percentile/100) * count($array);
        if (floor($index) == $index) {
             $result = ($array[$index-1] + $array[$index])/2;
        }
        else {
            $result = $array[floor($index)];
        }
        return $result;
    }*/

  
    
}
