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
      //  $posts = DB::select('SELECT * FROM jbox_dis_wt_quals');                                        
        //$posts  = Post::orderBy('created_at','desc')->paginate(2);
        //SELECT AVG(beadWt) as aveWt FROM (SELECT date,beadWt FROM jbox_dis_wt_quals WHERE date IN (SELECT * FROM view_jboxdiswt) )as tblview;
        $weightAve = DB::table(DB::select("SELECT AVG(beadWt) as aveWt FROM (SELECT date,beadWt FROM jbox_dis_wt_quals WHERE date IN (SELECT * FROM view_jboxdiswt) )as tblview"));
        $wtAve = number_format($weightAve->from[0]->aveWt,6);
        $weightStd = DB::table(DB::select("SELECT STDDEV_SAMP(beadWt) as aveStd FROM (SELECT date,beadWt FROM jbox_dis_wt_quals WHERE date IN (SELECT * FROM view_jboxdiswt) )as tblview"));
        $wtStd = number_format($weightStd->from[0]->aveStd,6);
        $weightAveOfAve = DB::table(DB::select("SELECT AVG(aveWt) as aveOfAve FROM ( SELECT date,AVG(beadWt) as aveWt FROM (SELECT date,beadWt FROM jbox_dis_wt_quals WHERE date IN (SELECT * FROM view_jboxdiswt)) as tblview GROUP BY date) as tblavgofavg"));
        $wtAveOfAve = number_format($weightAveOfAve->from[0]->aveOfAve,6);
        $weightStdOfStd = DB::table(DB::select("SELECT STDDEV_SAMP(stdWt) as stdOfStd FROM (SELECT date,AVG(beadWt) as stdWt FROM (SELECT date,beadWt FROM jbox_dis_wt_quals WHERE date IN (SELECT * FROM view_jboxdiswt)) as tblview GROUP BY date) as tbl_stdOfStd"));
        $wtStdOfStd = number_format($weightStdOfStd->from[0]->stdOfStd,6);
        
$median = DB::table(DB::select("SELECT ROUND(AVG(beadWt),6) as aveWt FROM (SELECT date,beadWt FROM jbox_dis_wt_quals WHERE date IN (SELECT * FROM view_jboxdiswt)  )as tblview GROUP BY date ORDER BY aveWt ASC"));
$medianCount = DB::table(DB::select("SELECT COUNT(aveWt) as aveCount FROM (SELECT ROUND(AVG(beadWt),6) as aveWt FROM (SELECT date,beadWt FROM jbox_dis_wt_quals WHERE date IN (SELECT * FROM view_jboxdiswt)  )as tblview GROUP BY date ORDER BY aveWt ASC) as tblcnt"));
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
$wtAveList = DB::table(DB::select("SELECT AVG(beadWt) as aveWt FROM (SELECT date,beadWt FROM jbox_dis_wt_quals WHERE date IN (SELECT * FROM view_jboxdiswt) )as tblview GROUP BY date"));
//dd($median);
$arrAve = array();
$arrVal= "";
for($i=0;$i<$medianCountVal ;$i++){
  //  $arrVal= $arrVal.$wtAveList->from[$i]->aveWt.',';
    array_push($arrAve,$wtAveList->from[$i]->aveWt);
}
$percentile = $this->mypercentile($arrAve,0.00135);
$percentile2 = $this->mypercentile($arrAve,0.99865);
 $UCL = 13.97;
 $LCL = 11.70;
//$CL = number_format($UCL-$LCL,4);
$CL = ($UCL-$LCL)/2+$LCL;
$target = 13;
$USL = $target + 2;
$LSL = $target - 2;
$CpL = ABS(number_format(($wtAveOfAve-$LCL)/(3*$wtStdOfStd),4));
$CpU = ABS(number_format(($UCL-$wtAveOfAve)/(3*$wtStdOfStd),4));
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
return view('backEnd.jBoxDisSum')
->with('ave',$wtAve)
->with('aveStdInd',$wtStd)
->with('aveOfAve',$wtAveOfAve)
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
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    }
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
}